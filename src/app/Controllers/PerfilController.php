<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class PerfilController{

    public function perfilClientes(){

        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/perfilCliente.html.twig', [
            'title' => 'Perfil'
        ]);

    }
    

}

?>