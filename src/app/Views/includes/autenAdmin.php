<?php
require_once("autenticacao.php");
if ($user_logado->tipo_usuario !== 'admin') {
    header("Location: /src/view/cliente/paginainicial.php");
    exit;
}