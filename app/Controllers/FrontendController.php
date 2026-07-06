<?php
// Controller responsável por servir as páginas visuais do sistema.
// Os dados são carregados pelo JavaScript via api.js após o carregamento da página.
class FrontendController
{
    public function pessoas(): void
    {
        exigirAutenticacao();
        $tituloPagina = 'Pessoas atendidas';
        require __DIR__ . '/../Views/pessoas/index.php';
    }

    public function tiposAtendimentos(): void
    {
        exigirAutenticacao();
        $tituloPagina = 'Tipos de atendimento';
        require __DIR__ . '/../Views/tipos-atendimento/index.php';
    }

    public function atendimentos(): void
    {
        exigirAutenticacao();
        $tituloPagina = 'Atendimentos';
        require __DIR__ . '/../Views/atendimentos/index.php';
    }
}