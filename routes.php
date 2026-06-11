<?php
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Controllers/TiposAtendimentoController.php';

$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action']     ?? 'index';

//USUARIOS
if ($controller === 'usuarios') {
    $usuariosController = new UsuariosController();

    switch ($action) {
        case 'listar':
            $usuariosController->listar();
            break;
        case 'buscar':
            $usuariosController->buscarPorId();
            break;
        case 'criar':
            $usuariosController->criar();
            break;
        case 'atualizar':
            $usuariosController->atualizar();
            break;
        case 'excluir':
            $usuariosController->excluir();
            break;
        default:
            echo json_encode(['erro' => 'Ação de usuários não encontrada.']);
            break;
    }

//TIPOS DE ATENDIMENTO 
} elseif ($controller === 'tipos_atendimento') {
    $tiposController = new TiposAtendimentoController();

    switch ($action) {
        case 'listar':
            $tiposController->listar();
            break;
        case 'buscar':
            $tiposController->buscarPorId();
            break;
        case 'criar':
            $tiposController->criar();
            break;
        case 'atualizar':
            $tiposController->atualizar();
            break;
        case 'inativar':
            $tiposController->inativar();
            break;
        default:
            echo json_encode(['erro' => 'Ação de tipos de atendimento não encontrada.']);
            break;
    }

// HOME
} else {
    echo '<h1>AtendeLab</h1>';
    echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
}