<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class NotificacoesController{

    public function notificacoesClientes(){

        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/notificacoes.html.twig', [
            'title' => 'Notificações'
        ]);

    }

    public function notificacoesBarbeiro(){

        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('gestor/notificacoesBarbeiro.html.twig', [
            'title' => 'Notificações'
        ]);

    }

    

}

?>