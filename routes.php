<?php
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Controllers/PessoasController.php';
require_once __DIR__ . '/app/Controllers/TiposAtendimentoController.php';
require_once __DIR__ . '/app/Controllers/AtendimentosController.php';
require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';
require_once __DIR__ . '/app/Controllers/FrontendController.php';
require_once __DIR__ . '/app/Controllers/RelatoriosController.php';
require_once __DIR__ . '/app/Middleware/auth.php';

$controller = $_GET['controller'] ?? 'auth';
$action     = $_GET['action']     ?? 'login';

// AUTH
if ($controller === 'auth') {
    $authController = new AuthController();

    switch ($action) {
        case 'login':
            $authController->exibirLogin();
            break;
        case 'entrar':
            $authController->entrar();
            break;
        case 'dashboard':
            $authController->dashboard();
            break;
        case 'logout':
            $authController->logout();
            break;
        default:
            http_response_code(404);
            echo 'Ação de autenticação não encontrada.';
            break;
    }

// USUARIOS
} elseif ($controller === 'usuarios') {
    exigirAutenticacao();
    $usuariosController = new UsuariosController();

    switch ($action) {
        case 'listar':
            $usuariosController->listar();
            break;
        case 'buscarPorId':
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
            echo 'Ação de usuários não encontrada.';
            break;
    }

// PESSOAS
} elseif ($controller === 'pessoas') {
    exigirAutenticacao();
    $pessoasController = new PessoasController();

    switch ($action) {
        case 'listar':
            $pessoasController->listar();
            break;
        case 'buscarPorId':
            $pessoasController->buscarPorId();
            break;
        case 'criar':
            $pessoasController->criar();
            break;
        case 'atualizar':
            $pessoasController->atualizar();
            break;
        case 'inativar':
            $pessoasController->inativar();
            break;
        case 'excluir':
            $pessoasController->excluir();
            break;
        default:
            echo 'Ação de pessoas não encontrada.';
            break;
    }

// TIPOS DE ATENDIMENTO
} elseif ($controller === 'tipos_atendimento') {
    exigirAutenticacao();
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
            echo 'Ação de tipos de atendimento não encontrada.';
            break;
    }

// ATENDIMENTOS
} elseif ($controller === 'atendimentos') {
    exigirAutenticacao();
    $atendimentosController = new AtendimentosController();

    switch ($action) {
        case 'listar':
            $atendimentosController->listar();
            break;
        case 'buscarPorId':
            $atendimentosController->buscarPorId();
            break;
        case 'criar':
            $atendimentosController->criar();
            break;
        case 'atualizar':
            $atendimentosController->atualizar();
            break;
        case 'atualizarStatus':
            $atendimentosController->atualizarStatus();
            break;
        default:
            echo 'Ação de atendimentos não encontrada.';
            break;
    }

// DASHBOARD
} elseif ($controller === 'dashboard') {
    exigirAutenticacao();
    $dashboardController = new DashboardController();

    switch ($action) {
        case 'resumo':
            $dashboardController->resumo();
            break;
        default:
            http_response_code(404);
            echo 'Ação de dashboard não encontrada.';
            break;
    }

// FRONTEND 
} elseif ($controller === 'frontend') {
    $frontendController = new FrontendController();

    switch ($action) {
        case 'pessoas':
            $frontendController->pessoas();
            break;
        case 'tiposAtendimentos':
            $frontendController->tiposAtendimentos();
            break;
        case 'atendimentos':
            $frontendController->atendimentos();
            break;
        default:
            http_response_code(404);
            echo 'Página não encontrada.';
            break;
    }

// RELATORIOS
} elseif ($controller === 'relatorios') {
    exigirAutenticacao();
    $relatoriosController = new RelatoriosController();

    switch ($action) {
        case 'atendimentos':
            $relatoriosController->atendimentos();
            break;
        default:
            http_response_code(404);
            echo 'Ação de relatórios não encontrada.';
            break;
    }

// HOME
} else {
    echo '<h1>AtendeLab</h1>';
    echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
}