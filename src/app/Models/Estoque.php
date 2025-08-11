<?php
namespace App\Models;

use PDO;

class Estoque
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = BD::getConnection();
    }

    public function listarTodos(): array
    {
        $sql = "SELECT * FROM estoque ORDER BY nome ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function excluirPorId(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM estoque WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function buscarPorId(int $id): ?object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM estoque WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function inserir(string $nome, int $quantidade, string $validade): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO estoque (nome, quantidade, validade) VALUES (:nome, :quantidade, :validade)");
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':validade', $validade, PDO::PARAM_STR); 
        return $stmt->execute();
    }

    public function atualizar(int $id, string $nome, int $quantidade, string $validade): bool
    {
        $stmt = $this->pdo->prepare("UPDATE estoque SET nome = :nome, quantidade = :quantidade, validade = :validade WHERE id = :id");
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':validade', $validade, PDO::PARAM_STR); // Assumindo que validade é uma string (data)
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

