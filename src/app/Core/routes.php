<?php

use App\Controllers\AppController;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Controllers\ContatoController;
use App\Controllers\BarbeiroController;
use App\Controllers\EstoqueController;
use App\Controllers\LogoutController;
use App\Controllers\NotificacoesController;
<<<<<<< HEAD
use App\Controllers\HistoricoController;
use App\Controllers\PerfilController;

=======
use App\Controllers\AgendamentoController;
>>>>>>> e082f3978c80867093d811d209cf340ee6409c91

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/router.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ##################################################
// Rotas utilizando PHPRouter - https://phprouter.com/
// ##################################################

// Página inicial
get('/', function () {
    (new AppController())->index();
});

// Login
get('/login', function () {
    (new UserController())->formLogin();
});
post('/login', function () {
    (new UserController())->login();
});

// Cadastro de usuário
get('/users/cadastro', function () {
    (new UserController())->formCadastro();
});
post('/users/cadastro', function () {
    (new UserController())->cadastro();
});

// Página inicial do usuário
get('/users/inicio', function () {
    (new HomeController())->homePage();
});

// Contato
get('/contato', function () {
    (new ContatoController())->formContato();
});
post('/contato', function () {
    (new ContatoController())->contato();
});

// Página inicial do barbeiro
get('/barbearia/home', function () {
    (new BarbeiroController())->homeBarbeiro();
});

// Estoque
get('/estoque', function () {
    (new EstoqueController())->index();
});
get('/estoque/novo', function () {
    (new EstoqueController())->formNovo();
});
post('/estoque/novo', function () {
    (new EstoqueController())->salvarNovo();
});
get('/estoque/editar/$id', function ($id) {
    (new EstoqueController())->formEditar((int)$id);
});
post('/estoque/editar/$id', function ($id) {
    (new EstoqueController())->atualizar((int)$id);
});
get('/estoque/excluir/$id', function ($id) {
    (new EstoqueController())->excluir((int)$id);
});

// Logout
get('/sair', function () {
    (new LogoutController())->sair();
});

// Notificações
get('/users/notificacoes', function () {
    (new NotificacoesController())->notificacoesClientes();
});
get('/barbearia/notificacoes', function () {
    (new NotificacoesController())->notificacoesBarbeiro();
});

<<<<<<< HEAD
get('/users/historico', function () {
  $controller = new HistoricoController();
  $controller->historicoClientes();
});

get('/users/perfil', function () {
  $controller = new PerfilController();
  $controller->perfilClientes();
});


=======
// 📌 Agendamentos
post('/agendamento/confirmar/$id', function ($id) {
    (new AgendamentoController())->confirmar((int)$id);
});
post('/agendamento/recusar/$id', function ($id) {
    (new AgendamentoController())->recusar((int)$id);
});
post('/agendamento/salvar', function () {
    (new AgendamentoController())->salvar();
});
>>>>>>> e082f3978c80867093d811d209cf340ee6409c91

// 404
any('/404', 'views/404.php');
