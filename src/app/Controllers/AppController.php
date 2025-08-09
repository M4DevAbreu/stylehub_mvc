<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\User;

class AppController {

    public static function protegerTipo(...$tiposEsperados) {
    if (
        !isset($_SESSION['usuario_id']) || 
        !in_array($_SESSION['tipo_usuario'], $tiposEsperados)
    ) {
        header('Location: /login');
        exit;
    }
}


    public function index() {
        $loader = new FilesystemLoader(__DIR__ . "/../Views");
        $twig = new Environment($loader);

        echo $twig->render("index.html.twig", [
            "title" => "StyleHub"
        ]);
    }
}
