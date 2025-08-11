<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\Barbeiro;
use App\Models\Estoque;       
use App\Models\Agendamento;
use App\Controllers\AppController;

class BarbeiroController
{
    public function homeBarbeiro()
    {
        AppController::protegerTipo('admin');

        $loader = new FilesystemLoader(__DIR__ . "/../Views");
        $twig = new Environment($loader);

        // Estoque
        $estoqueModel = new Estoque();           
        $itens = $estoqueModel->listarTodos();

        // Agendamentos pendentes para o barbeiro logado
        $agendamentoModel = new Agendamento();
        $agendamentos = [];

        if (isset($_SESSION['id'])) {
            $agendamentos = $agendamentoModel->listarPendentesPorCliente($_SESSION['id']);
        }

        // Renderiza a view passando estoque e agendamentos
        echo $twig->render('gestor/pagPrincipalBarbeiro.html.twig', [
            'title' => 'Home Barbearia',
            'nome' => $_SESSION['nome'] ?? 'Barbeiro',
            'itens' => $itens,
            'agendamentos' => $agendamentos
        ]);
    }
}
