<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class HistoricoController{

    public function historicoClientes(){

        $loader = new \Twig\loader\FilesystemLoader(__DIR__ . "/../Views");

        $twig = new \Twig\Environment($loader);

        echo $twig->render('user/historicoDeCorte.html.twig', [
            'title' => 'Historico de Cortes'
        ]);

    }
    

}

?>