<?php

use App\Controllers\AppController;
use App\Controllers\UserController;
use App\Controllers\HomeController;


require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/router.php';

// ##################################################
// Rotas elaboradas utilizando a biblioteca PHPRouter - https://phprouter.com/
// ##################################################

get('/', function () {
  $controller = new AppController();
  $controller->index();
});

get('/login', function () {
  $controller = new UserController();
  $controller->formLogin();
});

post('/login', function () {
  $controller = new UserController();
  $controller->Login();
});

get('/users/cadastro', function () {
  $controller = new UserController();
  $controller->formCadastro();
});

post('/users/cadastro', function () {
  $controller = new UserController();
  $controller->cadastro();
});

get('/users/inicio', function () {
  $controller = new HomeController();
  $controller->homePage();
});

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404', 'views/404.php');
