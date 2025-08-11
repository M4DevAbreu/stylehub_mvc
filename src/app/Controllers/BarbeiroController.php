<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\Barbeiro;
use App\Models\Estoque;       
use App\Controllers\AppController;

class BarbeiroController
{
    public function homeBarbeiro()
    {
        AppController::protegerTipo('admin');

        $loader = new FilesystemLoader(__DIR__ . "/../Views");
        $twig = new Environment($loader);

        $estoqueModel = new Estoque();           // instancia o model Estoque
        $itens = $estoqueModel->listarTodos();
      

        echo $twig->render('gestor/pagPrincipalBarbeiro.html.twig', [
            'title' => 'Home Barbearia',
            'nome' => $_SESSION['nome'],
            'itens' => $itens                      
        ]);
    }
}
