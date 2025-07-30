<?php
namespace App\Models;

use App\Models\BD;
use PDO;

class User{

    public  static function buscaEmail(string $email){
        $conn = BD::getConnection();

        $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(':email', $email, PDO::PARAM_STR);
        $sql->execute();
        
        return $sql->fetch(PDO::FETCH_OBJ);


    }

    public function cadastrar($dados){
        $conn = BD::getConnection();

        $sql = "INSERT INTO usuarios (nome, sobrenome, cpf, email, telefone, endereco, senha, genero, tipo_usuario) 
            VALUES (:nome, :sobrenome, :cpf, :email, :telefone, :endereco, :senha, :genero, :tipo_usuario)";
        $stmt = $conn->prepare($sql);
        $dados['tipo_usuario'] = $dados['tipo_usuario'] ?? 'cliente';
        $stmt->bindValue(':nome', $dados['nome']);
        $stmt->bindValue(':sobrenome', $dados['sobrenome']);
        $stmt->bindValue(':cpf', $dados['cpf']);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue(':telefone', $dados['telefone']);
        $stmt->bindValue(':endereco', $dados['endereco']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->bindValue(':genero', $dados['genero']);
        $stmt->bindValue(':tipo_usuario', $dados['tipo_usuario']);
        $stmt->execute();
    }
}

?>