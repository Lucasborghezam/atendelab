# AtendeLab

Sistema de Controle de Atendimentos Acadêmicos, desenvolvido na disciplina de Fábrica de
Software (Engenharia de Software, 5º período).

Repositório: https://github.com/Lucasborghezam/atendelab

## Sobre o projeto

O AtendeLab é um sistema para gerenciamento de atendimentos acadêmicos: cadastro de
pessoas atendidas, tipos de atendimento e registro dos atendimentos propriamente ditos,
com autenticação, dashboard de indicadores e relatórios por período.

O projeto é construído em PHP puro, sem framework, seguindo uma arquitetura MVC simples.
O acesso ao banco de dados é feito com PDO e prepared statements, a autenticação é
baseada em sessão, e o frontend consome uma API interna via JavaScript.

## Tecnologias

- PHP 8.x
- MySQL / MariaDB
- PDO
- HTML, CSS e JavaScript
- Bootstrap 5
- Git e GitHub

## Funcionalidades

- Autenticação com sessão e proteção de rotas
- Dashboard com indicadores gerais
- Cadastro de pessoas atendidas, com inativação lógica 
- Cadastro de tipos de atendimento
- Registro e acompanhamento de atendimentos, com controle de status
- Relatório de atendimentos por período

## Estrutura do projeto

```
atendelab/
├── app/
│   ├── Controllers/     regras de negócio e endpoints da aplicação
│   ├── Middleware/       autenticação e proteção de rotas
│   └── Views/            páginas HTML renderizadas pelo backend
├── config/
│   └── database.php      conexão com o banco via PDO
├── database/
│   └── atendelab.sql      script de criação do schema e dados iniciais
├── public/
│   ├── index.php          ponto de entrada da aplicação
│   └── assets/            arquivos estáticos (CSS e JavaScript)
├── routes.php             roteador da aplicação (controller + action)
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

