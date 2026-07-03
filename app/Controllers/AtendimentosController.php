<?php

class AtendimentosController
{
    
    private PDO $pdo;

    public function __construct()
    {
        
        require_once __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function listar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        
        $sql = 'SELECT 
                    a.id,
                    p.nome         AS pessoa,
                    t.nome         AS tipo_atendimento,
                    u.nome         AS atendente,
                    a.descricao_atendimento,
                    a.status,
                    a.data_atendimento,
                    a.atualizado_em
                FROM atendimentos a
                INNER JOIN pessoas           p ON p.id = a.pessoa_id
                INNER JOIN tipos_atendimento t ON t.id = a.tipo_atendimento_id
                INNER JOIN usuarios          u ON u.id = a.usuario_id
                ORDER BY a.id DESC';

        $stmt          = $this->pdo->query($sql);
        $atendimentos  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($atendimentos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function buscarPorId(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']);
            return;
        }

        $sql = 'SELECT 
                    a.id,
                    p.nome         AS pessoa,
                    t.nome         AS tipo_atendimento,
                    u.nome         AS atendente,
                    a.descricao_atendimento,
                    a.status,
                    a.data_atendimento,
                    a.atualizado_em
                FROM atendimentos a
                INNER JOIN pessoas           p ON p.id = a.pessoa_id
                INNER JOIN tipos_atendimento t ON t.id = a.tipo_atendimento_id
                INNER JOIN usuarios          u ON u.id = a.usuario_id
                WHERE a.id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $atendimento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$atendimento) {
            http_response_code(404);
            echo json_encode(['erro' => 'Atendimento não encontrado.']);
            return;
        }

        echo json_encode($atendimento, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function criar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $pessoa_id              = filter_input(INPUT_POST, 'pessoa_id',              FILTER_VALIDATE_INT);
        $tipo_atendimento_id    = filter_input(INPUT_POST, 'tipo_atendimento_id',    FILTER_VALIDATE_INT);
        $usuario_id             = filter_input(INPUT_POST, 'usuario_id',             FILTER_VALIDATE_INT);
        $descricao_atendimento  = trim($_POST['descricao_atendimento'] ?? '');
        $status                 = $_POST['status'] ?? 'concluido';

        if (!$pessoa_id || !$tipo_atendimento_id || !$usuario_id || $descricao_atendimento === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'pessoa_id, tipo_atendimento_id, usuario_id e descricao_atendimento são obrigatórios.']);
            return;
        }

        if (!in_array($status, ['em_andamento', 'concluido', 'cancelado'], true)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Status inválido. Use: em_andamento, concluido ou cancelado.']);
            return;
        }

        try {
            $sql = 'INSERT INTO atendimentos (pessoa_id, tipo_atendimento_id, usuario_id, descricao_atendimento, status)
                    VALUES (:pessoa_id, :tipo_atendimento_id, :usuario_id, :descricao_atendimento, :status)';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':pessoa_id',             $pessoa_id,             PDO::PARAM_INT);
            $stmt->bindValue(':tipo_atendimento_id',   $tipo_atendimento_id,   PDO::PARAM_INT);
            $stmt->bindValue(':usuario_id',            $usuario_id,            PDO::PARAM_INT);
            $stmt->bindValue(':descricao_atendimento', $descricao_atendimento);
            $stmt->bindValue(':status',                $status);
            $stmt->execute();

            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Atendimento cadastrado com sucesso.',
                'id'       => $this->pdo->lastInsertId()
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastrar atendimento. Verifique se os IDs informados existem.']);
        }
    }

    public function atualizarStatus(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id     = filter_input(INPUT_POST, 'id',     FILTER_VALIDATE_INT);
        $status = $_POST['status'] ?? '';

        if (!$id || $status === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'ID e status são obrigatórios.']);
            return;
        }

        if (!in_array($status, ['em_andamento', 'concluido', 'cancelado'], true)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Status inválido. Use: em_andamento, concluido ou cancelado.']);
            return;
        }

        try {
            $sql  = 'UPDATE atendimentos SET status = :status WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':id',     $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['mensagem' => 'Status do atendimento atualizado com sucesso.'], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar status do atendimento.']);
        }
    }

    public function atualizar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id                    = filter_input(INPUT_POST, 'id',                    FILTER_VALIDATE_INT);
        $pessoa_id             = filter_input(INPUT_POST, 'pessoa_id',             FILTER_VALIDATE_INT);
        $tipo_atendimento_id   = filter_input(INPUT_POST, 'tipo_atendimento_id',   FILTER_VALIDATE_INT);
        $usuario_id            = filter_input(INPUT_POST, 'usuario_id',            FILTER_VALIDATE_INT);
        $descricao_atendimento = trim($_POST['descricao_atendimento'] ?? '');
        $status                = $_POST['status'] ?? 'concluido';

        if (!$id || !$pessoa_id || !$tipo_atendimento_id || !$usuario_id || $descricao_atendimento === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'Todos os campos são obrigatórios.']);
            return;
        }

        if (!in_array($status, ['em_andamento', 'concluido', 'cancelado'], true)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Status inválido. Use: em_andamento, concluido ou cancelado.']);
            return;
        }

        try {
            $sql = 'UPDATE atendimentos
                    SET pessoa_id             = :pessoa_id,
                        tipo_atendimento_id   = :tipo_atendimento_id,
                        usuario_id            = :usuario_id,
                        descricao_atendimento = :descricao_atendimento,
                        status                = :status
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':pessoa_id',             $pessoa_id,             PDO::PARAM_INT);
            $stmt->bindValue(':tipo_atendimento_id',   $tipo_atendimento_id,   PDO::PARAM_INT);
            $stmt->bindValue(':usuario_id',            $usuario_id,            PDO::PARAM_INT);
            $stmt->bindValue(':descricao_atendimento', $descricao_atendimento);
            $stmt->bindValue(':status',                $status);
            $stmt->bindValue(':id',                    $id,                    PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['mensagem' => 'Atendimento atualizado com sucesso.'], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar atendimento.']);
        }
    }
}