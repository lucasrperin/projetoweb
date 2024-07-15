create schema projetoweb;

use projetoweb;

-- Copiando estrutura para tabela sistema.cadastros
CREATE TABLE IF NOT EXISTS `cadastros` (
  `cd_nome` int(11) NOT NULL AUTO_INCREMENT,
  `ds_nome` varchar(100) DEFAULT NULL,
  `ds_fone` varchar(50) DEFAULT NULL,
  `ds_email` varchar(50) DEFAULT NULL,
  `ds_cidade` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cd_nome`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela sistema.cadastros: ~5 rows (aproximadamente)
INSERT INTO `cadastros` (`cd_nome`, `ds_nome`, `ds_fone`, `ds_email`, `ds_cidade`) VALUES
	(2, 'max sd sd sd ds', '1431414', NULL, NULL),
	(3, 'carlos uberaba', '4864', 'asdf asdf asf ', '3245345 345 '),
	(6, 'aa a  a a a a a', '5555555', NULL, NULL),
	(7, 'd57d57d57', 'fgytfyty', '123412341234', 'xcicicicici '),
	(11, 'mnnnnnn  ', 'fofofofo', 'eememe e mee ', 'cicic ici?c'),
	(12, 'nn1n1n1n1 n1 ', 'ff11fg1f1f1f', 'e2e2e2e2e2e', 'cc8c78c8c8');

-- Copiando estrutura para tabela sistema.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `cd_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `ds_cliente` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_email` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_celular` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_cidade_cliente` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_uf_cliente` varchar(3) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_endereco` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_bairro` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_cep` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `ds_sexo` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `ds_cpf` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`cd_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema.clientes: ~3 rows (aproximadamente)
INSERT INTO `clientes` (`cd_cliente`, `ds_cliente`, `ds_email`, `ds_celular`, `ds_cidade_cliente`, `ds_uf_cliente`, `ds_endereco`, `ds_bairro`, `ds_cep`, `ds_sexo`, `dt_nascimento`, `ds_cpf`) VALUES
	(1, 'Carlos Silva', 'carlos@com.com', '49 9 88 77 66 55 ', '', '', 'rua la em ita, 8301', 'Norte', '89600-001', 'Machão', '2008-07-11', '098.123.423-11'),
	(2, 'Jessica Souza', 'jessica@sisisi.com', '49 98 7 7 7 7 7 ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(3, 'cauan de souza', 'chico@abc.com', '12435151235', '', '', 'rua la em ita, 8301', 'Norte', '89600-001', '', '1999-11-11', '098.123.423-11');

-- Copiando estrutura para tabela sistema.orcamentos
CREATE TABLE IF NOT EXISTS `orcamentos` (
  `cd_orcamento` int(11) NOT NULL AUTO_INCREMENT,
  `dt_orcamento` date NOT NULL,
  `cd_cliente_orcamento` int(6) NOT NULL DEFAULT 0,
  `cd_usuario_orcamento` int(6) NOT NULL DEFAULT 0,
  `vl_valor` float(8,2) NOT NULL DEFAULT 0.00,
  `ds_obs` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`cd_orcamento`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema.orcamentos: ~1 rows (aproximadamente)
INSERT INTO `orcamentos` (`cd_orcamento`, `dt_orcamento`, `cd_cliente_orcamento`, `cd_usuario_orcamento`, `vl_valor`, `ds_obs`) VALUES
	(1, '2022-10-27', 3, 3, 345.00, 'tudo blz');

-- Copiando estrutura para tabela sistema.orcamento_itens
CREATE TABLE IF NOT EXISTS `orcamento_itens` (
  `cd_oi` int(11) NOT NULL AUTO_INCREMENT,
  `cd_orcamento_oi` int(11) DEFAULT 0,
  `cd_produto_oi` int(11) DEFAULT 0,
  `ds_unidade` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `vl_quantidade` float(8,2) DEFAULT 0.00,
  `vl_unitario` float(8,2) DEFAULT 0.00,
  PRIMARY KEY (`cd_oi`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema.orcamento_itens: ~0 rows (aproximadamente)
INSERT INTO `orcamento_itens` (`cd_oi`, `cd_orcamento_oi`, `cd_produto_oi`, `ds_unidade`, `vl_quantidade`, `vl_unitario`) VALUES
	(20, 1, 1, NULL, 0.00, 0.00),
	(24, 1, 3, NULL, 0.00, 0.00);

-- Copiando estrutura para tabela sistema.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `cd_produto` int(11) NOT NULL AUTO_INCREMENT,
  `ds_produto` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `vl_estoque` int(11) NOT NULL DEFAULT 0,
  `vl_venda` numeric(18,4) NOT NULL DEFAULT 0,
  `ds_cor` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ds_categoria` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ds_unidade` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`cd_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema.produtos: ~5 rows (aproximadamente)
INSERT INTO `produtos` (`cd_produto`, `ds_produto`, `vl_estoque`, `vl_venda` , `ds_cor`, `ds_categoria`, `ds_unidade`) VALUES
	(1, 'abacaxi', 38, 11.90, 'verde', 'fruta', 'un'),
	(2, 'bananaa', 31, 12.90, 'amarelas', 'frutas', 'cxx'),
	(3, 'uva', 11, 13.90, 'preta', 'frutas', 'kg'),
	(4, 'figo', 14, 14.90, 'verde', 'flor', 'kg'),
	(5, 'tomate', 13, 15.90, 'vermelho', 'fruta', 'kg');

-- Copiando estrutura para tabela sistema.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `cd_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `ds_usuario` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ds_senha` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ds_email` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`cd_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema.usuarios: ~8 rows (aproximadamente)
INSERT INTO `usuarios` (`cd_usuario`, `ds_usuario`, `ds_senha`, `ds_email`) VALUES
	(1, 'ADM', '123', 'adm@adm.com');

-- Copiando estrutura para tabela sistema1.veiculos
CREATE TABLE IF NOT EXISTS `veiculos` (
  `cd_veiculo` int(11) NOT NULL AUTO_INCREMENT,
  `ds_veiculo` varchar(50) NOT NULL,
  `ds_placa` varchar(7) NOT NULL,
  `ds_cor` varchar(50) DEFAULT NULL,
  `ds_ano` varchar(4) DEFAULT NULL,
  `ds_modelo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cd_veiculo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema1.veiculos: ~0 rows (aproximadamente)
INSERT INTO `veiculos` (`cd_veiculo`, `ds_veiculo`, `ds_placa`, `ds_cor`, `ds_ano`, `ds_modelo`) VALUES
	(1, 'IX35', 'RYF6F95', 'Preto', '1990', 'Frestyle');

-- Copiando estrutura para tabela sistema1.viagens
CREATE TABLE IF NOT EXISTS `viagens` (
  `cd_viagem` int(11) NOT NULL AUTO_INCREMENT,
  `ds_origem` varchar(100) NOT NULL,
  `ds_destino` varchar(100) NOT NULL,
  `ds_placa` varchar(7) DEFAULT NULL,
  `ds_carga` varchar(50) DEFAULT NULL,
  `ds_valor` decimal(18,4) DEFAULT NULL,
  `dt_inicio` date DEFAULT NULL,
  `dt_fim` date DEFAULT NULL,
  PRIMARY KEY (`cd_viagem`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela sistema1.viagens: ~1 rows (aproximadamente)
INSERT INTO `viagens` (`cd_viagem`, `ds_origem`, `ds_destino`, `ds_placa`, `ds_carga`, `ds_valor`, `dt_inicio`, `dt_fim`) VALUES
	(1, 'Concórdia', 'Joaçaba', 'adsad12', 'Boi', 1000.5000, '2005-04-27', '2005-05-17');