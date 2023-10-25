-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Jul-2022 às 15:31
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdestoque_bebidas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_bebidas`
--

CREATE TABLE `tb_bebidas` (
  `BCodigo` int(11) NOT NULL,
  `BDescricao` varchar(50) NOT NULL,
  `BML` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_bebidas`
--

INSERT INTO `tb_bebidas` (`BCodigo`, `BDescricao`, `BML`) VALUES
(1, 'Whisky Johnnie Walker Black Label', 750),
(2, 'Whisky Ballantines Bourbon Barrel', 750),
(3, 'Whisky Chivas Regal 12 Anos', 1000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_estoque`
--

CREATE TABLE `tb_estoque` (
  `ECodigo` int(11) NOT NULL,
  `EBCodigo` int(11) NOT NULL,
  `EQtde` int(11) NOT NULL,
  `ECompra` decimal(10,2) NOT NULL,
  `EVenda` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_estoque`
--

INSERT INTO `tb_estoque` (`ECodigo`, `EBCodigo`, `EQtde`, `ECompra`, `EVenda`) VALUES
(1, 1, 5, '151.90', '212.66'),
(2, 1, 10, '139.90', '195.86'),
(3, 2, 12, '164.88', '184.55'),
(4, 3, 8, '119.90', '167.86'),
(5, 3, 6, '119.90', '167.86'),
(6, 1, 15, '139.90', '185.86');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_total`
--

CREATE TABLE `tb_total` (
  `TlCodigo` int(11) NOT NULL,
  `TlBeCodigo` int(11) NOT NULL,
  `TlQuantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_total`
--

INSERT INTO `tb_total` (`TlCodigo`, `TlBeCodigo`, `TlQuantidade`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_venda`
--

CREATE TABLE `tb_venda` (
  `VeCodigo` int(11) NOT NULL,
  `VeBeCodigo` int(11) NOT NULL,
  `VeQuantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_venda`
--

INSERT INTO `tb_venda` (`VeCodigo`, `VeBeCodigo`, `VeQuantidade`) VALUES
(2, 1, 5),
(6, 1, 5),
(7, 1, 5),
(9, 1, 2),
(10, 1, 20),
(11, 2, 20),
(12, 0, 20),
(13, 0, 20),
(14, 1, 20),
(15, 1, 20),
(16, 1, 20),
(17, 1, 20),
(18, 1, 20),
(19, 1, 20),
(20, 1, 5),
(21, 1, 100),
(22, 1, -100),
(23, 1, -52),
(24, 1, -46),
(25, 1, 10),
(26, 1, 10),
(27, 1, 20),
(28, 1, 5);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_bebidas`
--
ALTER TABLE `tb_bebidas`
  ADD PRIMARY KEY (`BCodigo`);

--
-- Índices para tabela `tb_estoque`
--
ALTER TABLE `tb_estoque`
  ADD PRIMARY KEY (`ECodigo`);

--
-- Índices para tabela `tb_total`
--
ALTER TABLE `tb_total`
  ADD PRIMARY KEY (`TlCodigo`,`TlBeCodigo`) USING BTREE;

--
-- Índices para tabela `tb_venda`
--
ALTER TABLE `tb_venda`
  ADD PRIMARY KEY (`VeCodigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_estoque`
--
ALTER TABLE `tb_estoque`
  MODIFY `ECodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_total`
--
ALTER TABLE `tb_total`
  MODIFY `TlCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_venda`
--
ALTER TABLE `tb_venda`
  MODIFY `VeCodigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
