<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController{

    public function homePage(){

        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'cliente') {
            header('Location: /login');
            exit;
        }

        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/paginainicial.html.twig', [
            'title' => 'Home Page',
            'nome' => $_SESSION['nome']
        ]);

    }



}

?>