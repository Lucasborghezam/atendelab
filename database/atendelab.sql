-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/07/2026 às 21:06
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atendelab`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atendimentos`
--

CREATE TABLE `atendimentos` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) NOT NULL,
  `tipo_atendimento_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `descricao_atendimento` text NOT NULL,
  `status` enum('aberto','em_andamento','concluido') DEFAULT 'aberto',
  `observacao_final` text DEFAULT NULL,
  `data_atendimento` datetime DEFAULT current_timestamp(),
  `horario_atendimento` time DEFAULT NULL,
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atendimentos`
--

INSERT INTO `atendimentos` (`id`, `pessoa_id`, `tipo_atendimento_id`, `usuario_id`, `descricao_atendimento`, `status`, `observacao_final`, `data_atendimento`, `horario_atendimento`, `atualizado_em`) VALUES
(2, 1, 3, 1, 'Aluno com dúvida sobre cálculo', 'em_andamento', NULL, '2026-07-02 22:37:14', NULL, '2026-07-03 01:37:14'),
(3, 1, 3, 1, 'Aluno com dúvida sobre cálculo', 'em_andamento', NULL, '2026-07-02 22:41:00', NULL, '2026-07-03 01:41:00'),
(4, 2, 4, 1, 'Aluno com dúvida sobre cálculo', 'em_andamento', NULL, '2026-07-02 23:16:40', NULL, '2026-07-03 02:16:40'),
(5, 1, 4, 1, 'Orientação sobre atividade avaliativa.', 'concluido', 'Atendimento concluído após orientação ao acadêmico.', '2026-07-05 14:39:11', '14:30:00', '2026-07-05 17:44:24'),
(6, 1, 4, 1, 'Orientação sobre atividade avaliativa.', 'aberto', NULL, '2026-07-05 16:00:52', '14:30:00', '2026-07-05 19:00:52');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoas`
--

CREATE TABLE `pessoas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `curso` varchar(120) DEFAULT NULL,
  `periodo` varchar(20) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pessoas`
--

INSERT INTO `pessoas` (`id`, `nome`, `documento`, `email`, `telefone`, `curso`, `periodo`, `observacoes`, `status`, `criado_em`, `atualizado_em`) VALUES
(1, 'Lucas Borghezam', '12052227903', 'lucas12alexandre3@gmail.com', '47996504514', NULL, NULL, NULL, 'ativo', '2026-07-03 01:28:42', '2026-07-05 14:47:52'),
(2, 'João da Silva', '53583893883', 'joao@email.com', '47995504514', NULL, NULL, NULL, 'ativo', '2026-07-03 01:34:02', '2026-07-05 14:47:52'),
(3, 'Maria da Silva', '53384853883', 'Maria@email.com', '47995502534', NULL, NULL, NULL, 'ativo', '2026-07-03 01:34:29', '2026-07-05 14:47:52'),
(4, 'Carlos Henrique Souza', '321.654.987-10', 'carlos.souza@exemplo.com', '(47) 99999-0010', 'Engenharia de Software', '3º', 'Aluno interessado em orientação sobre atividades complementares.', 'ativo', '2026-07-05 15:02:50', '2026-07-05 15:02:50'),
(5, 'Mariana Oliveira Costa', '741.852.963-20', 'mariana.oliveira@exemplo.com', '(47) 99999-0011', 'Sistemas de Informação', '5º', NULL, 'ativo', '2026-07-05 15:02:50', '2026-07-05 15:02:50'),
(6, 'Maria Eduarda Souza', '111.222.333-43', 'exemplo@teste.com', '(47)996403427', 'Engenharia de Software', '7º', NULL, 'inativo', '2026-07-05 15:56:03', '2026-07-05 16:29:47'),
(8, 'eduardo', '111.222.333-45', 'exemplo1@teste.com', '(47)996403423', 'Engenharia de Software', '7º', NULL, 'ativo', '2026-07-05 16:31:22', '2026-07-05 16:31:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos_atendimento`
--

CREATE TABLE `tipos_atendimento` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipos_atendimento`
--

INSERT INTO `tipos_atendimento` (`id`, `nome`, `descricao`, `status`, `criado_em`, `atualizado_em`) VALUES
(3, 'Dúvida acadêmica', 'Dúvidas sobre disciplinas, conteúdos e atividades', 'inativo', '2026-06-12 01:52:20', '2026-07-05 17:26:25'),
(4, 'Orientações de atividade', 'Orientações sobre trabalhos, TCC e projetos', 'ativo', '2026-06-12 01:53:26', '2026-07-05 14:49:09'),
(5, 'Suporte Técnico', 'Problemas com sistemas, equipamentos e acessos', 'ativo', '2026-06-12 01:54:15', '2026-07-05 14:49:09'),
(6, 'Revisão de avaliação', 'Solicitações de revisão de provas, trabalhos e atividades avaliativas.', 'ativo', '2026-07-05 15:01:55', '2026-07-05 15:01:55'),
(7, 'Apoio à extensão', 'Orientações relacionadas a projetos de extensão e atividades comunitárias.', 'ativo', '2026-07-05 15:01:55', '2026-07-05 15:01:55'),
(8, 'Orientação de projeto', 'Orientações acadêmicas sobre projetos integradores.', 'ativo', '2026-07-05 17:24:01', '2026-07-05 17:24:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','aluno','atendente') DEFAULT 'atendente',
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `status`, `criado_em`, `atualizado_em`) VALUES
(1, 'Administrador', 'admin@atendelab.com', '$2y$10$J9P2kU2BAMZ3TZcuxTsW4e1D/lka8EocYHzvyoOZmCNcWDQz3RuVC', 'admin', 'ativo', '2026-06-09 23:55:06', '2026-07-05 14:41:46'),
(5, 'Admin Teste', 'teste@atendelab.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'ativo', '2026-07-03 04:18:17', '2026-07-05 14:41:46');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_atendimentos_pessoa` (`pessoa_id`),
  ADD KEY `fk_atendimentos_tipo` (`tipo_atendimento_id`),
  ADD KEY `fk_atendimentos_usuario` (`usuario_id`);

--
-- Índices de tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documento` (`documento`);

--
-- Índices de tabela `tipos_atendimento`
--
ALTER TABLE `tipos_atendimento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tipos_atendimento`
--
ALTER TABLE `tipos_atendimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD CONSTRAINT `fk_atendimentos_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_atendimentos_tipo` FOREIGN KEY (`tipo_atendimento_id`) REFERENCES `tipos_atendimento` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_atendimentos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
