-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Ago 26, 2009 as 05:11 PM
-- Versão do Servidor: 5.1.30
-- Versão do PHP: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `services`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `complextype`
--

CREATE TABLE IF NOT EXISTS `complextype` (
  `id` int(11) NOT NULL,
  `idtype` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  KEY `idtype` (`idtype`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `complextype`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `function`
--

CREATE TABLE IF NOT EXISTS `function` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idwebservice` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `idReturnType` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idwebservice` (`idwebservice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `function`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `params`
--

CREATE TABLE IF NOT EXISTS `params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idfunction` int(11) NOT NULL,
  `idtype` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idfunction` (`idfunction`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `params`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idwebservice` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idfunction` (`idwebservice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `type`
--

INSERT INTO `type` (`id`, `idwebservice`, `name`, `code`) VALUES
(1, 0, 'string', 1),
(2, 0, 'token', 10),
(3, 0, 'ncname', 100),
(4, 0, 'anyuri', 10000),
(5, 0, 'qname', 100000),
(6, 0, 'boolean', 1000000),
(7, 0, 'int', 10000000),
(8, 0, 'integer', 10000000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `webservice`
--

CREATE TABLE IF NOT EXISTS `webservice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `webservice`
--

