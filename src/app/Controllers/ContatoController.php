<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

//Importa as dependências
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ContatoController {

    public function formContato() {
        $loader = new FilesystemLoader(__DIR__ . "/../Views");

        $twig = new Environment($loader);

        echo $twig->render("user/telaSuporte.html.twig", [
            "title" => "Contato StyleHub"
        ]);
    }

    public function contato() {
    $email = $_POST['destinatario'] ?? '';
    $assunto = $_POST['assunto'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    // Validação básica
    if (empty($email) || empty($assunto) || empty($mensagem)) {
        echo "Preencha todos os campos!";
        return;
    }

    // Criar o array com os dados
    $dados = [
        'email' => $email,
        'assunto' => $assunto,
        'mensagem' => $mensagem
    ];

    // Enviar para o broker de mensagens
    $this->enviarParaFila($dados);
    
    echo "Mensagem enviada com sucesso!";   

    }

    private function enviarParaFila($dados) {

    
    // Obtém o host da variável de ambiente, ou 'localhost' como default
    $rabbitmqHost = getenv('RABBITMQ_HOST') ?: 'localhost'; 

    $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection($rabbitmqHost, 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('fila_emails', false, true, false, false);

    $msg = new AMQPMessage(json_encode($dados), [
        'delivery_mode' => 2 // persistente
    ]);

    $channel->basic_publish($msg, '', 'fila_emails');

    $channel->close();
    $connection->close();
    
    }


}
