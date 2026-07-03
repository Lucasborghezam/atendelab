<?php

class PessoasController
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

        $sql = 'SELECT id, nome, documento, email, telefone, tipo_pessoa, criado_em
                FROM pessoas
                ORDER BY id DESC';

        $stmt    = $this->pdo->query($sql);
        $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($pessoas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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

        $sql = 'SELECT id, nome, documento, email, telefone, tipo_pessoa, criado_em
                FROM pessoas
                WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pessoa) {
            http_response_code(404);
            echo json_encode(['erro' => 'Pessoa não encontrada.']);
            return;
        }

        echo json_encode($pessoa, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function criar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $nome        = trim($_POST['nome']        ?? '');
        $documento   = trim($_POST['documento']   ?? '');
        $email       = trim($_POST['email']       ?? '');
        $telefone    = trim($_POST['telefone']     ?? '');
        $tipo_pessoa = $_POST['tipo_pessoa'] ?? 'aluno';

        if ($nome === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'O campo nome é obrigatório.']);
            return;
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail inválido.']);
            return;
        }

        if (!in_array($tipo_pessoa, ['aluno', 'professor', 'comunidade', 'outros'], true)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Tipo de pessoa inválido.']);
            return;
        }

        try {
            $sql = 'INSERT INTO pessoas (nome, documento, email, telefone, tipo_pessoa)
                    VALUES (:nome, :documento, :email, :telefone, :tipo_pessoa)';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome',        $nome);
            $stmt->bindValue(':documento',   $documento ?: null);
            $stmt->bindValue(':email',       $email     ?: null);
            $stmt->bindValue(':telefone',    $telefone  ?: null);
            $stmt->bindValue(':tipo_pessoa', $tipo_pessoa);
            $stmt->execute();

            http_response_code(201);
            echo json_encode([
                'mensagem' => 'Pessoa cadastrada com sucesso.',
                'id'       => $this->pdo->lastInsertId()
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao cadastrar pessoa.']);
        }
    }

    public function atualizar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id          = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nome        = trim($_POST['nome']        ?? '');
        $documento   = trim($_POST['documento']   ?? '');
        $email       = trim($_POST['email']       ?? '');
        $telefone    = trim($_POST['telefone']     ?? '');
        $tipo_pessoa = $_POST['tipo_pessoa'] ?? 'aluno';

        if (!$id || $nome === '') {
            http_response_code(400);
            echo json_encode(['erro' => 'ID e nome são obrigatórios.']);
            return;
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail inválido.']);
            return;
        }

        if (!in_array($tipo_pessoa, ['aluno', 'professor', 'comunidade', 'outros'], true)) {
            http_response_code(400);
            echo json_encode(['erro' => 'Tipo de pessoa inválido.']);
            return;
        }

        try {
            $sql = 'UPDATE pessoas
                    SET nome        = :nome,
                        documento   = :documento,
                        email       = :email,
                        telefone    = :telefone,
                        tipo_pessoa = :tipo_pessoa
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':nome',        $nome);
            $stmt->bindValue(':documento',   $documento ?: null);
            $stmt->bindValue(':email',       $email     ?: null);
            $stmt->bindValue(':telefone',    $telefone  ?: null);
            $stmt->bindValue(':tipo_pessoa', $tipo_pessoa);
            $stmt->bindValue(':id',          $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['mensagem' => 'Pessoa atualizada com sucesso.'], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao atualizar pessoa.']);
        }
    }

    public function excluir(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido.']);
            return;
        }

        try {
            $sql  = 'DELETE FROM pessoas WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['mensagem' => 'Pessoa excluída com sucesso.'], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao excluir pessoa. Verifique se há atendimentos vinculados.']);
        }
    }
}