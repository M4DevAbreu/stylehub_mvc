<?php
session_start();
require_once("../config/conexao.php");

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: /src/view/cliente/login.php");
    exit;
}

$sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$sql->bindValue(":id", $_SESSION['user_id']);
$sql->execute();
$user_logado = $sql->fetch(PDO::FETCH_OBJ);
