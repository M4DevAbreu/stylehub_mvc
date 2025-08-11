<?php

namespace App\Models;

use PDO;

class Agendamento
{
    private $conn;

    public function __construct()
    {
        $this->conn = BD::getConnection();
    }

    // Lista agendamentos pendentes por cliente
    public function listarPendentesPorCliente($clienteId)
    {
        $sql = "
            SELECT 
                a.id, 
                a.servicos, 
                a.data, 
                a.hora, 
                a.valor, 
                u.nome AS cliente
            FROM agendamentos a
            JOIN usuarios u ON a.id_cliente = u.id
            WHERE a.id_cliente = :cliente_id 
              AND a.status = 'pendente'
            ORDER BY STR_TO_DATE(a.data, '%d/%m/%Y'), a.hora
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':cliente_id', $clienteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lista agendamentos pendentes por barbeiro
    public function listarPendentesPorBarbeiro($barbeiroId)
    {
        $sql = "
            SELECT 
                a.id, 
                a.servicos, 
                a.data, 
                a.hora, 
                a.valor, 
                u.nome AS cliente
            FROM agendamentos a
            JOIN usuarios u ON a.id_cliente = u.id
            WHERE a.id_barbeiro = :barbeiro_id 
              AND a.status = 'pendente'
            ORDER BY STR_TO_DATE(a.data, '%d/%m/%Y'), a.hora
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':barbeiro_id', $barbeiroId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Confirmar agendamento
    public function confirmar($id)
    {
        $sql = "UPDATE agendamentos SET status = 'confirmado' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Cancelar agendamento
    public function cancelar($id)
    {
        $sql = "UPDATE agendamentos SET status = 'cancelado' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Salvar novo agendamento
    public function salvar($dados)
    {
        $sql = "
            INSERT INTO agendamentos (id_cliente, id_barbeiro, servicos, data, hora, valor, status) 
            VALUES (:id_cliente, :id_barbeiro, :servicos, :data, :hora, :valor, 'pendente')
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id_cliente', $dados['id_cliente'], PDO::PARAM_INT);
        $stmt->bindValue(':id_barbeiro', $dados['id_barbeiro'], PDO::PARAM_INT);
        $stmt->bindValue(':servicos', $dados['servicos'], PDO::PARAM_STR);
        $stmt->bindValue(':data', $dados['data'], PDO::PARAM_STR);
        $stmt->bindValue(':hora', $dados['hora'], PDO::PARAM_STR);
        $stmt->bindValue(':valor', $dados['valor'], PDO::PARAM_STR);

        return $stmt->execute();
    }
}
