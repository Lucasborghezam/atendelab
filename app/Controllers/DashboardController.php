<?php
// Controller responsável pelos dados exibidos no dashboard.
class DashboardController
{
    private PDO $pdo;

    public function __construct()
    {
        $pdo = require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function resumo(): void
    {
        exigirAutenticacao();
        header('Content-Type: application/json; charset=utf-8');

        $totalPessoas = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM pessoas WHERE status = 'ativo'")
            ->fetchColumn();

        $totalTipos = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM tipos_atendimento WHERE status = 'ativo'")
            ->fetchColumn();

        $totalAtendimentos = (int) $this->pdo
            ->query("SELECT COUNT(*) FROM atendimentos")
            ->fetchColumn();

        // Últimos 5 atendimentos pra exibir no dashboard.
        $sql = 'SELECT a.id,
                       p.nome AS pessoa,
                       t.nome AS tipo,
                       u.nome AS responsavel,
                       a.data_atendimento,
                       a.status
                FROM atendimentos a
                JOIN pessoas            p ON p.id = a.pessoa_id
                JOIN tipos_atendimento  t ON t.id = a.tipo_atendimento_id
                JOIN usuarios           u ON u.id = a.usuario_id
                ORDER BY a.id DESC
                LIMIT 5';

        $stmt = $this->pdo->query($sql);
        $recentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'indicadores' => [
                'total_pessoas'      => $totalPessoas,
                'total_tipos'        => $totalTipos,
                'total_atendimentos' => $totalAtendimentos,
            ],
            'atendimentos_recentes' => $recentes,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}