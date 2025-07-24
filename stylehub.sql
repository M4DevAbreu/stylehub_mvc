-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 26/06/2025 às 20:51
-- Versão do servidor: 9.3.0
-- Versão do PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `stylehub`
--

-- --------------------------------------------------------
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `genero` enum('feminino','masculino','personalizado') NOT NULL DEFAULT 'personalizado',
  `tipo_usuario` enum('cliente','gestor','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'cliente',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `cpf`, `email`, `telefone`, `endereco`, `senha`, `genero`, `tipo_usuario`, `ativo`, `data_criacao`) VALUES
(1, 'João', 'de abreu', '090.590.534-12', 'joao@email.com', '(63) 99295-7029', 'rua boa ', '$2y$12$ebNov0YKvWd0wDYT1RjTouj3MBp8mTLfLinkbP9n/XS4bo.lLr1Ny', 'masculino', 'cliente', 1, '2025-06-24 14:01:19'),
(2, 'matheus', 'de abreu', '090.590.534-12', 'matheusabreu2004silva1@gmail.com', '(63) 99295-7029', 'rua boa ', '$2y$12$48AeDdG4kv5SHJ6n/zdFU.v99QRVpaJeHOqqlHiKon.d.YjWY41X6', 'masculino', 'cliente', 1, '2025-06-24 14:03:20'),
(3, 'Chefe', 'de abreu', '090.590.534-12', 'editsneed@gmail.com', '(63) 99295-7029', 'rua boa ', '$2y$12$.aFkUoMME0RCvUNz3aTbHOZIBh9joS8Ev.0QJqO3NUvAqylvGsyOm', 'masculino', 'admin', 1, '2025-06-24 14:04:00'),
(4, 'Raianny', 'Silva', '567.890.789-23', 'raianny123@gmail.com', '(63) 99295-7029', 'rua boa ', '$2y$12$AfP0mghYGhjLJy.PPvJXxuIJy1ANYPkFLEskN7OJFtb/4J3iDj1f2', 'feminino', 'cliente', 1, '2025-06-26 11:41:21'),
(5, 'PEDRO', 'GONCALVES', '038.805.491-33', 'phrg1711@gmail.com', '63991011689', 'Rua 68', '$2y$12$1g.PkLaMSwxCgB4K9i6NUOEX9XFGd1xzvVaYQE94DgJHbGGgSlZoe', 'personalizado', 'cliente', 1, '2025-06-26 19:40:58');

-- --------------------------------------------------------
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_cliente` INT NOT NULL,
  `data` VARCHAR(255) NOT NULL,
  `hora` TIME NOT NULL,
  `servicos` VARCHAR(255) NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `descricao` TEXT,
  `criado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pendente', 'confirmado', 'cancelado') NOT NULL DEFAULT 'pendente',
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dados da tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `id_cliente`, `data`, `hora`, `servicos`, `valor`, `descricao`, `criado_em`, `status`) VALUES
(1, 5, '12/06/2025', '13:00:00', 'Manicure', 30.00, '', '2025-06-26 20:49:49', 'pendente');

-- --------------------------------------------------------
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `quantidade` INT NOT NULL,
  `validade` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Aqui você pode inserir dados, se quiser, por exemplo:
-- INSERT INTO `estoque` (`nome`, `quantidade`, `validade`) VALUES ('Shampoo', 10, '2025-12-31');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
