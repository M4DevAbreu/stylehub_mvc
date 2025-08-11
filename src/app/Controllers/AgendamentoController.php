<?php

namespace App\Controllers;

use App\Models\Agendamento;

class AgendamentoController extends AppController
{
    // Confirmar agendamento
    public function confirmar($id)
    {
        $this->protegerTipo('admin');

        $agendamentoModel = new Agendamento();
        if ($agendamentoModel->confirmar($id)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'success']);
        } else {
            header('Content-Type: application/json; charset=utf-8', true, 500);
            echo json_encode(['status' => 'error']);
        }
    }

    // Cancelar agendamento
    public function recusar($id)
    {
        $this->protegerTipo('admin');

        $agendamentoModel = new Agendamento();
        if ($agendamentoModel->cancelar($id)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'success']);
        } else {
            header('Content-Type: application/json; charset=utf-8', true, 500);
            echo json_encode(['status' => 'error']);
        }
    }

    // Salvar novo agendamento
    public function salvar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $debugFile = __DIR__ . '/../../../../tmp/stylehub_agendamento.log';
        file_put_contents($debugFile, date('c') . " - salvar() chamada. Method: " . ($_SERVER['REQUEST_METHOD'] ?? 'UNK') . PHP_EOL, FILE_APPEND);

        try {
            // Só permite POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido']);
                return;
            }

            $this->protegerTipo('cliente');

            // Coleta de dados (form-data ou JSON)
            $input = [];
            if (!empty($_POST)) {
                $input = $_POST;
            } else {
                $raw = file_get_contents('php://input');
                if (!empty($raw)) {
                    $decoded = json_decode($raw, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $input = $decoded;
                    } else {
                        file_put_contents($debugFile, date('c') . " - JSON inválido: {$raw}" . PHP_EOL, FILE_APPEND);
                    }
                }
            }

            // Monta dados para o Model
            $dados = [
                'id_cliente'  => $_SESSION['id'] ?? $_SESSION['usuario_id'] ?? null,
                'id_barbeiro' => $input['id_barbeiro'] ?? $input['barbeiro'] ?? null,
                'servicos'    => is_array($input['servicos']) ? json_encode($input['servicos']) : ($input['servicos'] ?? ''),
                'data'        => $input['data'] ?? $input['date'] ?? '',
                'hora'        => $input['horario'] ?? $input['hora'] ?? '',
                'valor'       => $input['total'] ?? $input['valor'] ?? 0,
                'comentarios' => $input['comentarios'] ?? ''
            ];

            file_put_contents($debugFile, date('c') . " - Dados recebidos: " . print_r($dados, true) . PHP_EOL, FILE_APPEND);

            $agendamentoModel = new Agendamento();

            if ($agendamentoModel->salvar($dados)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['sucesso' => true]);
            } else {
                header('Content-Type: application/json; charset=utf-8', true, 500);
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao salvar agendamento.']);
            }
        } catch (\Throwable $e) {
            file_put_contents($debugFile, date('c') . " - Exceção: " . $e->getMessage() . PHP_EOL . $e->getTraceAsString() . PHP_EOL, FILE_APPEND);
            header('Content-Type: application/json; charset=utf-8', true, 500);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno no servidor.']);
        }
    }
}
