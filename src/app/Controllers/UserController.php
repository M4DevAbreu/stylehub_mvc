<?php

namespace App\Controllers;

use App\Models\BD;
use App\Models\User;

use PDO; 

class userController{

    public function formLogin(){
        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/login.html.twig', [
            'title' => 'Login'

        ]);
    }

    public function Login(){

        $email = $_POST["email"] ?? '';
        $senha = $_POST["senha"] ?? '';

        if (empty($email) || empty($senha)) {
            echo "preencha todoos os campos";
            return;
        }

        try{

            $usuario = User::buscaEmail($email);

            if ($usuario &&password_verify($senha, $usuario->senha)) {
                $_SESSION['usuario_id'] = $usuario -> id;
                $_SESSION['nome'] = $usuario ->nome;
                $_SESSION['tipo'] = $usuario->tipo_usuario;

                header('Location: /Telainicial');
                exit;
            } else{
                $_SESSION['error_login'] = 'Email ou senha inválidos.';
                header('Location: /login');
                exit;
            }
        } catch (\PDOException $e){
            error_log('Erro ao fazer login: ' . $e->getMessage());
            echo 'Erro interno, tente novamente!';
        }
    
    }

}

?>
