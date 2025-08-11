<?php
namespace App\Controllers;

use App\Models\Estoque;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class EstoqueController
{
    private Estoque $estoqueModel;
    private Environment $twig;

    public function __construct()
    {
        
        $this->estoqueModel = new Estoque();

        
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);
    }

    public function index()
    {
        $itens = $this->estoqueModel->listarTodos();

        echo $this->twig->render('gestor/controleEstoque.html.twig', [
            'title' => 'Estoque',
            'itens' => $itens
        ]);
    }

    public function formNovo()
{
    echo $this->twig->render('gestor/formEstoque.html.twig', [
        'title' => 'Novo item',
        'item'  => null,
        'acao'  => '/estoque/novo'
    ]);
}

public function formEditar(int $id)
{
    $item = $this->estoqueModel->buscarPorId($id);
    echo $this->twig->render('gestor/formEstoque.html.twig', [
        'title' => 'Editar item',
        'item'  => $item,
        'acao'  => '/estoque/editar/' . $id
    ]);
}

public function salvarNovo()
{
    $nome = $_POST['nome'] ?? '';
    $quantidade = $_POST['quantidade'] ?? 0; 
    $validade = $_POST['validade'] ?? ''; 
    
    
    if ($nome) {
        
        $this->estoqueModel->inserir($nome, $quantidade, $validade);
    }

    
    header('Location: /estoque');
    exit;
}

public function atualizar(int $id)
{
    $nome = $_POST['nome'] ?? '';
    $quantidade = $_POST['quantidade'] ?? 0; 
    $validade = $_POST['validade'] ?? ''; 
    
    if ($nome) {
        $this->estoqueModel->atualizar($id, $nome, $quantidade, $validade);
    }

    header('Location: /estoque');
    exit;
}



public function excluir(int $id)
    {
        $this->estoqueModel->excluirPorId($id);
        header('Location: /estoque');
        exit;
    }

}
