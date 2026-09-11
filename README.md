# AtendeLab

Sistema de Controle de Atendimentos Acadêmicos, desenvolvido na disciplina de Fábrica de
Software (Engenharia de Software, 5º período).

Repositório: https://github.com/Lucasborghezam/atendelab

## Sobre o projeto

O AtendeLab é um sistema para gerenciamento de atendimentos acadêmicos: cadastro de
pessoas atendidas, tipos de atendimento e registro dos atendimentos propriamente ditos,
com autenticação, gestão de usuários, dashboard de indicadores e relatórios por período.

O projeto é construído em PHP puro, sem framework, seguindo uma arquitetura MVC simples.
Um front controller único (`routes.php`) concentra o roteamento: ele recebe os
parâmetros `controller` e `action` via query string e despacha para o método
correspondente. O acesso ao banco de dados usa PDO e prepared statements, a
autenticação usa sessão, e o frontend (HTML + JavaScript) consome essa API
interna via `fetch`.

## Tecnologias

- PHP 8.x
- MySQL / MariaDB
- PDO
- HTML, CSS e JavaScript
- Bootstrap 5
- Git e GitHub

## Funcionalidades

- Autenticação com sessão e proteção de rotas (middleware)
- Dashboard com indicadores gerais
- Gestão de usuários (CRUD)
- Cadastro de pessoas atendidas, com inativação lógica
- Cadastro de tipos de atendimento, com inativação lógica
- Registro e acompanhamento de atendimentos, com controle de status
- Relatório de atendimentos por período

## Estrutura do projeto

```
atendelab/
├── app/
│   ├── Controllers/            regras de negócio e endpoints da aplicação
│   │   ├── AuthController.php           login, sessão e logout
│   │   ├── UsuariosController.php       CRUD de usuários
│   │   ├── PessoasController.php        CRUD de pessoas atendidas
│   │   ├── TiposAtendimentoController.php  CRUD de tipos de atendimento
│   │   ├── AtendimentosController.php   CRUD e status de atendimentos
│   │   ├── DashboardController.php      indicadores gerais
│   │   ├── RelatoriosController.php     relatório por período
│   │   └── FrontendController.php       renderização das páginas (views)
│   ├── Middleware/
│   │   └── auth.php             proteção de rotas autenticadas
│   └── Views/                    páginas HTML renderizadas pelo backend
│       ├── auth/                 tela de login
│       ├── dashboard/            tela de indicadores
│       ├── pessoas/               tela de pessoas atendidas
│       ├── tipos-atendimento/     tela de tipos de atendimento
│       ├── atendimentos/         tela de atendimentos
│       └── layouts/              header, sidebar e footer compartilhados
├── config/
│   └── database.php              conexão com o banco via PDO
├── database/
│   └── atendelab.sql             script de criação do schema e dados iniciais
├── public/
│   ├── index.php                 ponto de entrada da aplicação
│   └── assets/
│       ├── css/style.css         estilos da aplicação
│       └── js/api.js             consumo da API interna via fetch
├── routes.php                    roteador da aplicação (controller + action)
└── README.md
```

## Como executar localmente

1. Clone o repositório:

   ```
   git clone https://github.com/Lucasborghezam/atendelab.git
   ```

2. Copie a pasta `atendelab` para o diretório `htdocs` do XAMPP.
3. Inicie os serviços Apache e MySQL pelo painel do XAMPP.
4. Crie o banco de dados `atendelab`.
5. Importe o script `database/atendelab.sql` pelo phpMyAdmin.
6. Verifique as credenciais de acesso em `config/database.php`.
7. Acesse a aplicação em `http://localhost/atendelab/public/`.
