<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Controllers\AppController;


class HomeController{

    public function homePage(){

        AppController::protegerTipo('cliente');
        
        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/paginainicial.html.twig', [
            'title' => 'Home Page',
            'nome' => $_SESSION['nome']
        ]);

    }



}

?>