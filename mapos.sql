#
# TABLE STRUCTURE FOR: anexos
#

DROP TABLE IF EXISTS `anexos`;

CREATE TABLE `anexos` (
  `idAnexos` int NOT NULL AUTO_INCREMENT,
  `anexo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thumb` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `path` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os_id` int NOT NULL,
  PRIMARY KEY (`idAnexos`),
  KEY `fk_anexos_os1` (`os_id`),
  CONSTRAINT `fk_anexos_os1` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: anotacoes_os
#

DROP TABLE IF EXISTS `anotacoes_os`;

CREATE TABLE `anotacoes_os` (
  `idAnotacoes` int NOT NULL AUTO_INCREMENT,
  `anotacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_hora` datetime NOT NULL,
  `os_id` int NOT NULL,
  PRIMARY KEY (`idAnotacoes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: caixas
#

DROP TABLE IF EXISTS `caixas`;

CREATE TABLE `caixas` (
  `idCaixa` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `data_abertura` datetime NOT NULL,
  `data_fechamento` datetime DEFAULT NULL,
  `saldo_inicial` decimal(10,2) DEFAULT '0.00',
  `saldo_final` decimal(10,2) DEFAULT NULL,
  `status` enum('aberto','fechado') NOT NULL DEFAULT 'aberto',
  `observacao` text,
  PRIMARY KEY (`idCaixa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `caixas` (`idCaixa`, `usuario_id`, `data_abertura`, `data_fechamento`, `saldo_inicial`, `saldo_final`, `status`, `observacao`) VALUES (1, 1, '2026-01-25 15:00:30', '2026-01-25 19:28:46', '100.00', '100.00', 'fechado', NULL);


#
# TABLE STRUCTURE FOR: categorias
#

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `idCategorias` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cadastro` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idCategorias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: checklist_items
#

DROP TABLE IF EXISTS `checklist_items`;

CREATE TABLE `checklist_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_id` int NOT NULL,
  `item` varchar(200) NOT NULL,
  `ordem` int DEFAULT '0',
  `obrigatorio` tinyint(1) DEFAULT '0',
  `permite_foto` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `checklist_items_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `checklist_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: checklist_os
#

DROP TABLE IF EXISTS `checklist_os`;

CREATE TABLE `checklist_os` (
  `id` int NOT NULL AUTO_INCREMENT,
  `os_id` int NOT NULL,
  `template_id` int NOT NULL,
  `data_preenchimento` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `os_id` (`os_id`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `checklist_os_ibfk_1` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`) ON DELETE CASCADE,
  CONSTRAINT `checklist_os_ibfk_2` FOREIGN KEY (`template_id`) REFERENCES `checklist_templates` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: checklist_respostas
#

DROP TABLE IF EXISTS `checklist_respostas`;

CREATE TABLE `checklist_respostas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `checklist_os_id` int NOT NULL,
  `item_id` int NOT NULL,
  `status` enum('ok','nao_ok','na') DEFAULT 'na',
  `observacao` text,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `checklist_os_id` (`checklist_os_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `checklist_respostas_ibfk_1` FOREIGN KEY (`checklist_os_id`) REFERENCES `checklist_os` (`id`) ON DELETE CASCADE,
  CONSTRAINT `checklist_respostas_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `checklist_items` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: checklist_templates
#

DROP TABLE IF EXISTS `checklist_templates`;

CREATE TABLE `checklist_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  `imagem_referencia` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: ci_sessions
#

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('hu18c2jeih1h7em0e87um7p3s6vkv0dt', '::1', 1768791343, '__ci_last_regenerate|i:1768791343;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('822l00auc5ak2rlp5uud5c52a5bvtpbs', '::1', 1768791712, '__ci_last_regenerate|i:1768791712;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6jir41l2fl364a7dm4e8v7cr75cooe5r', '::1', 1768791874, '__ci_last_regenerate|i:1768791712;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7gefolbm1a92kgmt3qam4hk6s2m4k8ck', '::1', 1768819534, '__ci_last_regenerate|i:1768819534;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('nnlsme1fd2e37r5ot78hi7eo55jurtgu', '::1', 1768820339, '__ci_last_regenerate|i:1768820339;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('be0ef6pfk4uoe55lj0aj7idrpjpv7p3b', '::1', 1768820706, '__ci_last_regenerate|i:1768820706;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('vsk17bpfdf8243d3aoj5np4ad67u98dd', '::1', 1768821328, '__ci_last_regenerate|i:1768821328;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('q9mgf8bvbc9ar8k8k3lnqgb7adts2t4t', '::1', 1768821691, '__ci_last_regenerate|i:1768821691;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('74grae72nka1agail8i5d5p5mkhbv8es', '::1', 1768822477, '__ci_last_regenerate|i:1768822477;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bce1bu7ssbgt6im9j7o5ca5qnitehpcu', '::1', 1768822881, '__ci_last_regenerate|i:1768822881;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ea4vk69ur7gn280n8r4se7t5o0rjonh4', '::1', 1768823380, '__ci_last_regenerate|i:1768823380;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ddm1fku54htcbfvc7o2vavptncbql3i0', '::1', 1768823579, '__ci_last_regenerate|i:1768823380;nome_admin|s:13:\"administrador\";email_admin|s:25:\"gnsolucoes.info@gmail.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('39c1fa70a90b1f73ced88df38e9e277cd081d612', '127.0.0.1', 1769305676, '__ci_last_regenerate|i:1769305676;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('073ba0f7b177ea8775226ee529c0c166208a9b58', '127.0.0.1', 1769306847, '__ci_last_regenerate|i:1769306847;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a74e33247ddad50df3db2bb9ebf141f126aaa750', '::1', 1769306401, '__ci_last_regenerate|i:1769306401;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('42ce7e1a95e933a09ac87c097e5fdfc0718cc9bd', '::1', 1769306835, '__ci_last_regenerate|i:1769306835;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('75bb434ee2377f2ec23e4574344b78c2834a69d9', '127.0.0.1', 1769306805, '__ci_last_regenerate|i:1769306805;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2df6168911fe33adc5fe315b74f8c09b6cac220e', '::1', 1769307232, '__ci_last_regenerate|i:1769307232;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;success|s:28:\"Configurações atualizadas!\";__ci_vars|a:1:{s:7:\"success\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4d362613227437f3b85c1d10cc03d1e415e37350', '127.0.0.1', 1769307709, '__ci_last_regenerate|i:1769307709;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8ef727637a5241ae40e225345f93649f9fa71c76', '::1', 1769307562, '__ci_last_regenerate|i:1769307562;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7635f4f71b3d56cb47946a558b93ef91ec7a26a0', '::1', 1769307911, '__ci_last_regenerate|i:1769307911;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a9ff94c6e18d512ff99b746bef3baa9aa8ffddb6', '127.0.0.1', 1769308082, '__ci_last_regenerate|i:1769308082;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('131fd21c3a8c2bee89803492c55e09af94848602', '::1', 1769308242, '__ci_last_regenerate|i:1769308242;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('58d7f3e45acbaa7c42b3a8c62fb99cb73c7f0cb6', '127.0.0.1', 1769309779, '__ci_last_regenerate|i:1769309779;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('13dfb27cb5328aa78ecabcc7b6b29b788fc00ecb', '::1', 1769308635, '__ci_last_regenerate|i:1769308635;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3bb7faed16bb65f40eab1bda22b3fa0a0d13f7df', '::1', 1769308986, '__ci_last_regenerate|i:1769308986;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('161e902238b970a8dd0e87303b28fe8c484473fa', '::1', 1769309402, '__ci_last_regenerate|i:1769309402;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('07c1b214b4c5a1129fa14e4afb8a216ac803cd8c', '::1', 1769309716, '__ci_last_regenerate|i:1769309716;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fb6c966cd93f0e45eca3ac837063b067ba501e11', '::1', 1769310019, '__ci_last_regenerate|i:1769310019;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('79cbc77ac6207a748baa1f417155cbb3cc6853c2', '127.0.0.1', 1769309779, '__ci_last_regenerate|i:1769309779;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('54245559bd08a8d5b28d9068974f4973e87513da', '::1', 1769310371, '__ci_last_regenerate|i:1769310371;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0c579d20ffd436c812578d51c927980cd7e64e52', '::1', 1769310758, '__ci_last_regenerate|i:1769310758;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('56511c339963bb26db0506b2fbb6e7709bbde770', '::1', 1769311165, '__ci_last_regenerate|i:1769311165;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('aedeae5c3fd98c7ef2761087d124ff1662e2a84e', '::1', 1769311247, '__ci_last_regenerate|i:1769311165;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('eda4487ec3983e48224e248c94ce44343da3bfb4', '::1', 1769342853, '__ci_last_regenerate|i:1769342853;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0314b712e0750b64be8e4f69320650d836ef415d', '::1', 1769347569, '__ci_last_regenerate|i:1769347569;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('aded9889ba3ffbe1bbd160b4707c166b284a788c', '::1', 1769343545, '__ci_last_regenerate|i:1769343545;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6bedf9c64d070b025d5b879833fcfdbfa9b7fe36', '::1', 1769343846, '__ci_last_regenerate|i:1769343846;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('874abb7503b71a0bf5957c87c1c79761d6d64d2b', '::1', 1769344171, '__ci_last_regenerate|i:1769344171;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9abf9ff514f4abc0c72a1db0dce7a01f0d3840f0', '::1', 1769344959, '__ci_last_regenerate|i:1769344959;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b4049376e67307e6d30dec14d376dcf0c8cf9017', '::1', 1769345362, '__ci_last_regenerate|i:1769345362;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6eae742c10e49fe34b2aa3cac3ba3d738e597441', '::1', 1769347658, '__ci_last_regenerate|i:1769347658;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e0766b246fa41a09f7d00b2aa13376703f3aac0c', '::1', 1769349241, '__ci_last_regenerate|i:1769349241;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1ca5e0f3237259dd61ff6e5aef6979962aa8be86', '::1', 1769348088, '__ci_last_regenerate|i:1769348029;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('18c9e0300e7363b304901c902aaeef8e46e97fd1', '::1', 1769351783, '__ci_last_regenerate|i:1769351783;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f3ed5830af1c4322baee7622b6cb0272f419b192', '::1', 1769352411, '__ci_last_regenerate|i:1769352411;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d3011377113e66eebd62e8361cb59116a03a34ec', '::1', 1769353166, '__ci_last_regenerate|i:1769353166;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b874b7a302041820b9b223fa90a75db7f744cd2c', '::1', 1769353693, '__ci_last_regenerate|i:1769353693;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7b3250226ae3bc2d708b5d5beb5b9fb19f62e5b9', '::1', 1769354842, '__ci_last_regenerate|i:1769354842;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('144ee1fbdb45479801492d5090c12bee2f4d8444', '::1', 1769355148, '__ci_last_regenerate|i:1769355148;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b3c398f7597cbc4908cbd9b9c4d3ff344b02a914', '::1', 1769356865, '__ci_last_regenerate|i:1769356865;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b8387a1b4fc36bcf02f8d794e97db7875cfaebe2', '::1', 1769357180, '__ci_last_regenerate|i:1769357180;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2b90761cc95bb1e405c4c54ea61c607ff1d4ffd5', '127.0.0.1', 1769357556, '__ci_last_regenerate|i:1769357556;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('71f05db2b02e870851b355982f7450b4cb0c4639', '::1', 1769357507, '__ci_last_regenerate|i:1769357507;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ef210f55fb90273486437e71d6d4377fbd129d56', '::1', 1769358027, '__ci_last_regenerate|i:1769358027;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1fb1f2dc5ea10e843fce2012aa0ad95b973c03c3', '127.0.0.1', 1769357556, '__ci_last_regenerate|i:1769357556;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0a08b445a1f6841f42445e008880803d83e03561', '::1', 1769359009, '__ci_last_regenerate|i:1769359009;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ba5733d3e82e1ac7286ca362e9ffc0b700c59d69', '::1', 1769359324, '__ci_last_regenerate|i:1769359324;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('232436870f440249d71c3d19cf96a3806b74fe8f', '::1', 1769359824, '__ci_last_regenerate|i:1769359824;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f6770ef1d83a23802e8b0f0ab73898fdaf35bdd1', '::1', 1769360859, '__ci_last_regenerate|i:1769360859;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6fcb01ba1a7b19eecbf45bbb3f198b1567801e46', '::1', 1769361634, '__ci_last_regenerate|i:1769361634;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('758905bece2abedafdbb8d4b7751e2523c0d9a57', '::1', 1769362594, '__ci_last_regenerate|i:1769362594;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a31f5b9fc38d339350fce5e9d105dd0bbe5a249b', '::1', 1769363197, '__ci_last_regenerate|i:1769363197;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a1f644d1edd53778d4bbae0c05fe6ae4cbd63a3d', '::1', 1769363725, '__ci_last_regenerate|i:1769363725;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('05ed2c751d706b2544916030fbc2254be5b9aa7c', '::1', 1769365302, '__ci_last_regenerate|i:1769365302;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('73975f302f34f9d13a19c14cd3332572604c7b82', '::1', 1769365753, '__ci_last_regenerate|i:1769365753;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;error|s:40:\"Sessão expirada. Faça login novamente.\";__ci_vars|a:1:{s:5:\"error\";s:3:\"new\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('77dbde48718ab59aa3cc5ff33c605d344a13915c', '::1', 1769366243, '__ci_last_regenerate|i:1769366243;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2fbbda15ed75a0272ca7cd519e81db2d44570757', '127.0.0.1', 1769366233, '__ci_last_regenerate|i:1769366233;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('498a20c1b12e11f72c13de67c0ce49e75d485846', '::1', 1769366266, '__ci_last_regenerate|i:1769366243;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;error|s:40:\"Sessão expirada. Faça login novamente.\";__ci_vars|a:1:{s:5:\"error\";s:3:\"new\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d237bf06a4e71a9cc618658e01b5bfe14c21ea9c', '::1', 1769377213, '__ci_last_regenerate|i:1769377213;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ab7932c8a7ab247b7ada806514d33f42972d7ecf', '::1', 1769377601, '__ci_last_regenerate|i:1769377601;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('33db9886d4a7c74c4a7ad2ada78f4ce16c3c3119', '::1', 1769378236, '__ci_last_regenerate|i:1769378236;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2b2fcd37aa9fd8f4961fcecf970c7435db9b884a', '::1', 1769378841, '__ci_last_regenerate|i:1769378841;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f4b5ef9d91d771ba6c0dc87bc58dd3476daa98da', '::1', 1769379175, '__ci_last_regenerate|i:1769379175;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5bf87d0c37f9b02aa327992a6fafe11e6ae87845', '::1', 1769379774, '__ci_last_regenerate|i:1769379774;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9f42a18b9e70c09ad9bc73f0e69c0211825d21f9', '::1', 1769380100, '__ci_last_regenerate|i:1769380100;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e3d74802eb1286d14d201e0ccdcad222f654180b', '::1', 1769380713, '__ci_last_regenerate|i:1769380713;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7a0ecfae2fa0458470b684be9b55985c09edc856', '::1', 1769381656, '__ci_last_regenerate|i:1769381656;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c9d91dec0384333fe62ba23914cdb625f4641d85', '::1', 1769382189, '__ci_last_regenerate|i:1769382189;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b53fc7d10ac1ec41500465d6d68f4916e8ca0b48', '::1', 1769382189, '__ci_last_regenerate|i:1769382189;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('p283jri5vbokc6h3eoc2sugfp18c24av', '127.0.0.1', 1769449998, '__ci_last_regenerate|i:1769449769;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fmsre64qon80krm0anms7pm0i9h9hvcq', '::1', 1769450238, '__ci_last_regenerate|i:1769450238;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1crjvml5nra3r7hpfc958gt2vva6dl6r', '::1', 1769450608, '__ci_last_regenerate|i:1769450608;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ri56au3luk1hr60vb1euu9ukfr92i9pe', '::1', 1769451083, '__ci_last_regenerate|i:1769451083;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d9239qs4aav469srul6tmatb4vu0pltv', '::1', 1769454018, '__ci_last_regenerate|i:1769454018;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7r3jrqh2dk5gnorneqbl161n5otcbkj5', '::1', 1769454408, '__ci_last_regenerate|i:1769454408;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6ri5a6sa4ga2q0ifju5pdqs940c73qni', '::1', 1769454591, '__ci_last_regenerate|i:1769454408;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ius18dd7nc63kn6dp3eflk9rmrtn0f6e', '127.0.0.1', 1773938427, '__ci_last_regenerate|i:1773938427;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('08qnrpjs8m3ett5cr2dbrl8ahe8gcdhv', '127.0.0.1', 1773942487, '__ci_last_regenerate|i:1773942487;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('s40h1ufn7rig27l69mjn1930s0629g3v', '127.0.0.1', 1773945563, '__ci_last_regenerate|i:1773945563;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('lp0lemjcjjkej10ejee8bu44stgrf9tj', '127.0.0.1', 1773945868, '__ci_last_regenerate|i:1773945868;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5pmdq9vroq9dp7c2hdv7ai8k2vbi9tb2', '127.0.0.1', 1773946253, '__ci_last_regenerate|i:1773946253;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('iqtb7pi0u592g332a6o0kg44lg6sv2pf', '127.0.0.1', 1773946640, '__ci_last_regenerate|i:1773946640;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('pgjlvfp9h4grk9o811f7kgpfhr89asvp', '127.0.0.1', 1773947124, '__ci_last_regenerate|i:1773947124;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0te5iludcqar9lo71tvjbbs69egl1hhr', '127.0.0.1', 1773947431, '__ci_last_regenerate|i:1773947431;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e6b55ajtvothn2sk8kcnpr1vlo29ct3f', '127.0.0.1', 1773948632, '__ci_last_regenerate|i:1773948632;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8a3n5uijokc6opbt33up3mj8ce1jc7p5', '127.0.0.1', 1773949048, '__ci_last_regenerate|i:1773949048;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8q57gle7rjikssv9h09hr4vsurfgobum', '127.0.0.1', 1773949839, '__ci_last_regenerate|i:1773949839;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('u85mvjptq45hkioapkr6ai4a8624ohhg', '127.0.0.1', 1773950527, '__ci_last_regenerate|i:1773950527;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cm5qutm69eq52rll51m21ju1n0p90nlc', '127.0.0.1', 1773951632, '__ci_last_regenerate|i:1773951632;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('l3d103u5sqfsdu7uct332iobbffceljd', '127.0.0.1', 1773953540, '__ci_last_regenerate|i:1773953540;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('48hvb49vovv88ka9ccj0jqd6kivpe80q', '127.0.0.1', 1773953855, '__ci_last_regenerate|i:1773953855;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bkjsqir1j77ugerug1tccii8foqff42g', '127.0.0.1', 1773954172, '__ci_last_regenerate|i:1773954172;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('q6l4v33cm4918tc44s38gqfdd0cecgom', '127.0.0.1', 1773954713, '__ci_last_regenerate|i:1773954713;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('u5en6mi4hlsj45eg3rnrhesp667k8ume', '127.0.0.1', 1773955014, '__ci_last_regenerate|i:1773955014;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('sc64lkmtra3dep5f2c51qa0lld211sji', '127.0.0.1', 1773955043, '__ci_last_regenerate|i:1773955014;nome_admin|s:13:\"administrador\";email_admin|s:15:\"admin@admin.com\";url_image_user_admin|N;id_admin|s:1:\"1\";permissao|s:1:\"1\";logado|b:1;');


#
# TABLE STRUCTURE FOR: clientes
#

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `idClientes` int NOT NULL AUTO_INCREMENT,
  `asaas_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomeCliente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sexo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pessoa_fisica` tinyint(1) NOT NULL DEFAULT '1',
  `documento` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `celular` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dataCadastro` date DEFAULT NULL,
  `rua` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cep` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contato` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complemento` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fornecedor` tinyint(1) NOT NULL DEFAULT '0',
  `parceiros_id` int DEFAULT NULL,
  PRIMARY KEY (`idClientes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: cobrancas
#

DROP TABLE IF EXISTS `cobrancas`;

CREATE TABLE `cobrancas` (
  `idCobranca` int NOT NULL AUTO_INCREMENT,
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `conditional_discount_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `custom_id` int DEFAULT NULL,
  `expire_at` date NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_method` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `request_delivery_address` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vendas_id` int DEFAULT NULL,
  `os_id` int DEFAULT NULL,
  `clientes_id` int DEFAULT NULL,
  PRIMARY KEY (`idCobranca`),
  KEY `fk_cobrancas_os1` (`os_id`),
  KEY `fk_cobrancas_vendas1` (`vendas_id`),
  KEY `fk_cobrancas_clientes1` (`clientes_id`),
  CONSTRAINT `fk_cobrancas_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`idClientes`),
  CONSTRAINT `fk_cobrancas_os1` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`),
  CONSTRAINT `fk_cobrancas_vendas1` FOREIGN KEY (`vendas_id`) REFERENCES `vendas` (`idVendas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: compras
#

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_compra` varchar(50) DEFAULT NULL,
  `fornecedor_id` int NOT NULL,
  `data_compra` date NOT NULL,
  `data_entrega` date DEFAULT NULL,
  `status` enum('orcamento','aprovado','pedido','recebido','cancelado') DEFAULT 'orcamento',
  `valor_total` decimal(10,2) DEFAULT '0.00',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `frete` decimal(10,2) DEFAULT '0.00',
  `observacoes` text,
  `usuario_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_compra` (`numero_compra`),
  KEY `fornecedor_id` (`fornecedor_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `clientes` (`idClientes`),
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: compras_itens
#

DROP TABLE IF EXISTS `compras_itens`;

CREATE TABLE `compras_itens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `compra_id` int NOT NULL,
  `produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `compra_id` (`compra_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `compras_itens_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `compras_itens_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`idProdutos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: compras_pagamentos
#

DROP TABLE IF EXISTS `compras_pagamentos`;

CREATE TABLE `compras_pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `compra_id` int NOT NULL,
  `lancamento_id` int DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_vencimento` date NOT NULL,
  `data_pagamento` date DEFAULT NULL,
  `status` enum('pendente','pago','atrasado') DEFAULT 'pendente',
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `observacoes` text,
  PRIMARY KEY (`id`),
  KEY `compra_id` (`compra_id`),
  KEY `lancamento_id` (`lancamento_id`),
  CONSTRAINT `compras_pagamentos_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `compras_pagamentos_ibfk_2` FOREIGN KEY (`lancamento_id`) REFERENCES `lancamentos` (`idLancamentos`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: configuracoes
#

DROP TABLE IF EXISTS `configuracoes`;

CREATE TABLE `configuracoes` (
  `idConfig` int NOT NULL AUTO_INCREMENT,
  `config` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `valor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`idConfig`),
  UNIQUE KEY `config` (`config`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (2, 'app_name', 'Map-OS');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (3, 'app_theme', 'white');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (4, 'per_page', '10');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (5, 'os_notification', 'cliente');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (6, 'control_estoque', '1');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (7, 'notifica_whats', 'Prezado(a), {CLIENTE_NOME} a OS de nº {NUMERO_OS} teve o status alterado para: {STATUS_OS} segue a descrição {DESCRI_PRODUTOS} com valor total de {VALOR_OS}! Para mais informações entre em contato conosco. Atenciosamente, {EMITENTE} {TELEFONE_EMITENTE}.');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (8, 'control_baixa', '0');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (9, 'control_editos', '1');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (10, 'control_datatable', '1');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (11, 'pix_key', '');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (12, 'os_status_list', '[\"Aberto\",\"Faturado\",\"Negocia\\u00e7\\u00e3o\",\"Em Andamento\",\"Or\\u00e7amento\",\"Finalizado\",\"Cancelado\",\"Aguardando Pe\\u00e7as\",\"Aprovado\"]');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (13, 'control_edit_vendas', '1');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (14, 'email_automatico', '1');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (15, 'control_2vias', '0');
INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (16, 'tawk_to_embed', '');


#
# TABLE STRUCTURE FOR: contas
#

DROP TABLE IF EXISTS `contas`;

CREATE TABLE `contas` (
  `idContas` int NOT NULL AUTO_INCREMENT,
  `conta` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banco` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `cadastro` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tipo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idContas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: contas_bancarias
#

DROP TABLE IF EXISTS `contas_bancarias`;

CREATE TABLE `contas_bancarias` (
  `idConta` int unsigned NOT NULL AUTO_INCREMENT,
  `conta` varchar(100) NOT NULL,
  `banco` varchar(100) DEFAULT NULL,
  `agencia` varchar(50) DEFAULT NULL,
  `numero_conta` varchar(50) DEFAULT NULL,
  `saldo_inicial` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `data_cadastro` datetime DEFAULT NULL,
  PRIMARY KEY (`idConta`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `contas_bancarias` (`idConta`, `conta`, `banco`, `agencia`, `numero_conta`, `saldo_inicial`, `status`, `data_cadastro`) VALUES (1, 'Caixa Geral', 'Interno', NULL, NULL, '0.00', 1, '2026-01-24 23:10:55');


#
# TABLE STRUCTURE FOR: documentos
#

DROP TABLE IF EXISTS `documentos`;

CREATE TABLE `documentos` (
  `idDocumentos` int NOT NULL AUTO_INCREMENT,
  `documento` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `path` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cadastro` date DEFAULT NULL,
  `categoria` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tamanho` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idDocumentos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: email_queue
#

DROP TABLE IF EXISTS `email_queue`;

CREATE TABLE `email_queue` (
  `id` int NOT NULL AUTO_INCREMENT,
  `to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bcc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pending','sending','sent','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `headers` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: emitente
#

DROP TABLE IF EXISTS `emitente`;

CREATE TABLE `emitente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cnpj` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ie` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rua` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uf` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url_logo` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cep` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: equipamentos
#

DROP TABLE IF EXISTS `equipamentos`;

CREATE TABLE `equipamentos` (
  `idEquipamentos` int NOT NULL AUTO_INCREMENT,
  `equipamento` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `num_serie` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modelo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cor` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descricao` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tensao` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `potencia` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `voltagem` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_fabricacao` date DEFAULT NULL,
  `marcas_id` int DEFAULT NULL,
  `clientes_id` int DEFAULT NULL,
  PRIMARY KEY (`idEquipamentos`),
  KEY `fk_equipanentos_marcas1_idx` (`marcas_id`),
  KEY `fk_equipanentos_clientes1_idx` (`clientes_id`),
  CONSTRAINT `fk_equipanentos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`idClientes`),
  CONSTRAINT `fk_equipanentos_marcas1` FOREIGN KEY (`marcas_id`) REFERENCES `marcas` (`idMarcas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: equipamentos_os
#

DROP TABLE IF EXISTS `equipamentos_os`;

CREATE TABLE `equipamentos_os` (
  `idEquipamentos_os` int NOT NULL AUTO_INCREMENT,
  `defeito_declarado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `defeito_encontrado` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `solucao` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `equipamentos_id` int DEFAULT NULL,
  `os_id` int DEFAULT NULL,
  PRIMARY KEY (`idEquipamentos_os`),
  KEY `fk_equipamentos_os_equipanentos1_idx` (`equipamentos_id`),
  KEY `fk_equipamentos_os_os1_idx` (`os_id`),
  CONSTRAINT `fk_equipamentos_os_equipanentos1` FOREIGN KEY (`equipamentos_id`) REFERENCES `equipamentos` (`idEquipamentos`),
  CONSTRAINT `fk_equipamentos_os_os1` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: garantias
#

DROP TABLE IF EXISTS `garantias`;

CREATE TABLE `garantias` (
  `idGarantias` int NOT NULL AUTO_INCREMENT,
  `dataGarantia` date DEFAULT NULL,
  `refGarantia` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `textoGarantia` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `usuarios_id` int DEFAULT NULL,
  PRIMARY KEY (`idGarantias`),
  KEY `fk_garantias_usuarios1` (`usuarios_id`),
  CONSTRAINT `fk_garantias_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: itens_de_vendas
#

DROP TABLE IF EXISTS `itens_de_vendas`;

CREATE TABLE `itens_de_vendas` (
  `idItens` int NOT NULL AUTO_INCREMENT,
  `subTotal` decimal(10,2) DEFAULT '0.00',
  `quantidade` int DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT '0.00',
  `vendas_id` int NOT NULL,
  `produtos_id` int NOT NULL,
  PRIMARY KEY (`idItens`),
  KEY `fk_itens_de_vendas_vendas1` (`vendas_id`),
  KEY `fk_itens_de_vendas_produtos1` (`produtos_id`),
  CONSTRAINT `fk_itens_de_vendas_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`idProdutos`),
  CONSTRAINT `fk_itens_de_vendas_vendas1` FOREIGN KEY (`vendas_id`) REFERENCES `vendas` (`idVendas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: lancamentos
#

DROP TABLE IF EXISTS `lancamentos`;

CREATE TABLE `lancamentos` (
  `idLancamentos` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT '0.00',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `valor_desconto` decimal(10,2) DEFAULT '0.00',
  `tipo_desconto` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_vencimento` date NOT NULL,
  `data_pagamento` date DEFAULT NULL,
  `baixado` tinyint(1) DEFAULT '0',
  `cliente_fornecedor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forma_pgto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anexo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `clientes_id` int DEFAULT NULL,
  `categorias_id` int DEFAULT NULL,
  `contas_id` int DEFAULT NULL,
  `vendas_id` int DEFAULT NULL,
  `usuarios_id` int NOT NULL,
  `contas_bancaria_id` int unsigned DEFAULT '1',
  PRIMARY KEY (`idLancamentos`),
  KEY `fk_lancamentos_clientes1` (`clientes_id`),
  KEY `fk_lancamentos_categorias1_idx` (`categorias_id`),
  KEY `fk_lancamentos_contas1_idx` (`contas_id`),
  KEY `fk_lancamentos_usuarios1` (`usuarios_id`),
  CONSTRAINT `fk_lancamentos_categorias1` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`idCategorias`),
  CONSTRAINT `fk_lancamentos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`idClientes`),
  CONSTRAINT `fk_lancamentos_contas1` FOREIGN KEY (`contas_id`) REFERENCES `contas` (`idContas`),
  CONSTRAINT `fk_lancamentos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: logs
#

DROP TABLE IF EXISTS `logs`;

CREATE TABLE `logs` (
  `idLogs` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tarefa` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `ip` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idLogs`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (1, 'administrador', 'Efetuou login no sistema', '2026-01-18', '23:48:31', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (2, 'administrador', 'Efetuou login no sistema', '2026-01-19', '07:32:24', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (3, 'administrador', 'Efetuou login no sistema', '2026-01-19', '08:47:57', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (4, 'administrador', 'Efetuou login no sistema', '2026-01-19', '08:52:19', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (5, 'administrador', 'Efetuou login no sistema', '2026-01-24', '23:01:48', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (6, 'administrador', 'Efetuou login no sistema', '2026-01-25', '00:04:48', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (7, 'administrador', 'Efetuou login no sistema', '2026-01-25', '09:02:47', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (8, 'administrador', 'Efetuou login no sistema', '2026-01-25', '09:19:05', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (9, 'administrador', 'Efetuou login no sistema', '2026-01-25', '10:27:50', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (10, 'administrador', 'Efetuou login no sistema', '2026-01-25', '10:30:43', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (11, 'administrador', 'Adicionou um usuário.', '2026-01-25', '10:32:01', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (12, 'Tecnico Teste', 'Efetuou login no sistema', '2026-01-25', '10:32:48', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (13, 'administrador', 'Efetuou login no sistema', '2026-01-25', '10:34:00', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (14, 'administrador', 'Efetuou login no sistema', '2026-01-25', '14:38:51', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (15, 'administrador', 'Efetuou login no sistema', '2026-01-25', '14:56:50', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (16, 'administrador', 'Efetuou login no sistema', '2026-01-25', '15:37:37', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (17, 'administrador', 'Efetuou login no sistema', '2026-01-25', '18:24:56', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (18, 'administrador', 'Efetuou backup do banco de dados.', '2026-01-25', '19:30:07', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (19, 'administrador', 'Efetuou login no sistema', '2026-01-26', '14:50:06', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (20, 'administrador', 'Efetuou login no sistema', '2026-01-26', '14:53:27', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (21, 'administrador', 'Efetuou login no sistema', '2026-01-26', '16:06:48', '::1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (22, 'administrador', 'Efetuou login no sistema', '2026-03-19', '14:49:01', '127.0.0.1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (23, 'administrador', 'Efetuou login no sistema', '2026-03-19', '15:41:28', '127.0.0.1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (24, 'administrador', 'Efetuou login no sistema', '2026-03-19', '16:32:08', '127.0.0.1');
INSERT INTO `logs` (`idLogs`, `usuario`, `tarefa`, `data`, `hora`, `ip`) VALUES (25, 'administrador', 'Efetuou backup do banco de dados.', '2026-03-19', '18:01:52', '127.0.0.1');


#
# TABLE STRUCTURE FOR: marcas
#

DROP TABLE IF EXISTS `marcas`;

CREATE TABLE `marcas` (
  `idMarcas` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cadastro` date DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idMarcas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: migrations
#

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `migrations` (`version`) VALUES ('20210125173741');


#
# TABLE STRUCTURE FOR: orcamentos
#

DROP TABLE IF EXISTS `orcamentos`;

CREATE TABLE `orcamentos` (
  `idOrcamento` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `empresa` varchar(150) DEFAULT NULL,
  `equipamentos` varchar(250) NOT NULL,
  `descricao` text NOT NULL,
  `endereco` text,
  `status` varchar(50) DEFAULT 'Pendente',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idOrcamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: os
#

DROP TABLE IF EXISTS `os`;

CREATE TABLE `os` (
  `idOs` int NOT NULL AUTO_INCREMENT,
  `dataInicial` date DEFAULT NULL,
  `dataFinal` date DEFAULT NULL,
  `garantia` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descricaoProduto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `defeito` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `laudoTecnico` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `valorTotal` decimal(10,2) DEFAULT '0.00',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `valor_desconto` decimal(10,2) DEFAULT '0.00',
  `tipo_desconto` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `clientes_id` int NOT NULL,
  `usuarios_id` int NOT NULL,
  `lancamento` int DEFAULT NULL,
  `faturado` tinyint(1) NOT NULL,
  `garantias_id` int DEFAULT NULL,
  `tipo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Externo',
  `os_rapida` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idOs`),
  KEY `fk_os_clientes1` (`clientes_id`),
  KEY `fk_os_usuarios1` (`usuarios_id`),
  KEY `fk_os_lancamentos1` (`lancamento`),
  KEY `fk_os_garantias1` (`garantias_id`),
  CONSTRAINT `fk_os_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`idClientes`),
  CONSTRAINT `fk_os_lancamentos1` FOREIGN KEY (`lancamento`) REFERENCES `lancamentos` (`idLancamentos`),
  CONSTRAINT `fk_os_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: parceiros
#

DROP TABLE IF EXISTS `parceiros`;

CREATE TABLE `parceiros` (
  `idParceiros` int NOT NULL AUTO_INCREMENT,
  `ome` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(20) DEFAULT NULL,
  `elefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comissao` decimal(10,2) DEFAULT '0.00',
  `dataCadastro` date DEFAULT NULL,
  `situacao` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`idParceiros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# TABLE STRUCTURE FOR: patrimonio_manutencoes
#

DROP TABLE IF EXISTS `patrimonio_manutencoes`;

CREATE TABLE `patrimonio_manutencoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patrimonio_id` int NOT NULL,
  `data_manutencao` date NOT NULL,
  `tipo` enum('preventiva','corretiva') NOT NULL,
  `descricao` text,
  `custo` decimal(10,2) DEFAULT NULL,
  `responsavel_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patrimonio_id` (`patrimonio_id`),
  KEY `responsavel_id` (`responsavel_id`),
  CONSTRAINT `patrimonio_manutencoes_ibfk_1` FOREIGN KEY (`patrimonio_id`) REFERENCES `patrimonios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `patrimonio_manutencoes_ibfk_2` FOREIGN KEY (`responsavel_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: patrimonios
#

DROP TABLE IF EXISTS `patrimonios`;

CREATE TABLE `patrimonios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text,
  `categoria` varchar(50) DEFAULT NULL,
  `marca_id` int DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `num_serie` varchar(100) DEFAULT NULL,
  `data_aquisicao` date DEFAULT NULL,
  `valor_aquisicao` decimal(10,2) DEFAULT NULL,
  `fornecedor_id` int DEFAULT NULL,
  `localizacao` varchar(100) DEFAULT NULL,
  `estado` enum('novo','bom','regular','ruim') DEFAULT 'bom',
  `status` enum('ativo','manutencao','inativo','baixado') DEFAULT 'ativo',
  `foto` varchar(255) DEFAULT NULL,
  `observacoes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `marca_id` (`marca_id`),
  KEY `fornecedor_id` (`fornecedor_id`),
  CONSTRAINT `patrimonios_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`idMarcas`) ON DELETE SET NULL,
  CONSTRAINT `patrimonios_ibfk_2` FOREIGN KEY (`fornecedor_id`) REFERENCES `clientes` (`idClientes`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

#
# TABLE STRUCTURE FOR: permissoes
#

DROP TABLE IF EXISTS `permissoes`;

CREATE TABLE `permissoes` (
  `idPermissao` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `permissoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `situacao` tinyint(1) DEFAULT NULL,
  `data` date DEFAULT NULL,
  PRIMARY KEY (`idPermissao`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `permissoes` (`idPermissao`, `nome`, `permissoes`, `situacao`, `data`) VALUES (1, 'Administrador', 'a:49:{s:8:\"aCliente\";s:1:\"1\";s:8:\"eCliente\";s:1:\"1\";s:8:\"dCliente\";s:1:\"1\";s:8:\"vCliente\";s:1:\"1\";s:8:\"aProduto\";s:1:\"1\";s:8:\"eProduto\";s:1:\"1\";s:8:\"dProduto\";s:1:\"1\";s:8:\"vProduto\";s:1:\"1\";s:8:\"aServico\";s:1:\"1\";s:8:\"eServico\";s:1:\"1\";s:8:\"dServico\";s:1:\"1\";s:8:\"vServico\";s:1:\"1\";s:3:\"aOs\";s:1:\"1\";s:3:\"eOs\";s:1:\"1\";s:3:\"dOs\";s:1:\"1\";s:3:\"vOs\";s:1:\"1\";s:6:\"aVenda\";s:1:\"1\";s:6:\"eVenda\";s:1:\"1\";s:6:\"dVenda\";s:1:\"1\";s:6:\"vVenda\";s:1:\"1\";s:9:\"aGarantia\";s:1:\"1\";s:9:\"eGarantia\";s:1:\"1\";s:9:\"dGarantia\";s:1:\"1\";s:9:\"vGarantia\";s:1:\"1\";s:8:\"aArquivo\";s:1:\"1\";s:8:\"eArquivo\";s:1:\"1\";s:8:\"dArquivo\";s:1:\"1\";s:8:\"vArquivo\";s:1:\"1\";s:11:\"aLancamento\";s:1:\"1\";s:11:\"eLancamento\";s:1:\"1\";s:11:\"dLancamento\";s:1:\"1\";s:11:\"vLancamento\";s:1:\"1\";s:8:\"cUsuario\";s:1:\"1\";s:9:\"cEmitente\";s:1:\"1\";s:10:\"cPermissao\";s:1:\"1\";s:7:\"cBackup\";s:1:\"1\";s:10:\"cAuditoria\";s:1:\"1\";s:6:\"cEmail\";s:1:\"1\";s:8:\"cSistema\";s:1:\"1\";s:8:\"rCliente\";s:1:\"1\";s:8:\"rProduto\";s:1:\"1\";s:8:\"rServico\";s:1:\"1\";s:3:\"rOs\";s:1:\"1\";s:6:\"rVenda\";s:1:\"1\";s:11:\"rFinanceiro\";s:1:\"1\";s:9:\"aCobranca\";s:1:\"1\";s:9:\"eCobranca\";s:1:\"1\";s:9:\"dCobranca\";s:1:\"1\";s:9:\"vCobranca\";s:1:\"1\";}', 1, '2026-01-24');
INSERT INTO `permissoes` (`idPermissao`, `nome`, `permissoes`, `situacao`, `data`) VALUES (2, 'Técnico', 'a:49:{s:8:\"aCliente\";s:1:\"1\";s:8:\"eCliente\";s:1:\"1\";s:8:\"dCliente\";s:1:\"0\";s:8:\"vCliente\";s:1:\"1\";s:8:\"aProduto\";s:1:\"0\";s:8:\"eProduto\";s:1:\"0\";s:8:\"dProduto\";s:1:\"0\";s:8:\"vProduto\";s:1:\"1\";s:8:\"aServico\";s:1:\"0\";s:8:\"eServico\";s:1:\"0\";s:8:\"dServico\";s:1:\"0\";s:8:\"vServico\";s:1:\"1\";s:3:\"aOs\";s:1:\"1\";s:3:\"eOs\";s:1:\"1\";s:3:\"dOs\";s:1:\"0\";s:3:\"vOs\";s:1:\"1\";s:6:\"aVenda\";s:1:\"0\";s:6:\"eVenda\";s:1:\"0\";s:6:\"dVenda\";s:1:\"0\";s:6:\"vVenda\";s:1:\"1\";s:9:\"aGarantia\";s:1:\"0\";s:9:\"eGarantia\";s:1:\"0\";s:9:\"dGarantia\";s:1:\"0\";s:9:\"vGarantia\";s:1:\"1\";s:8:\"aArquivo\";s:1:\"1\";s:8:\"eArquivo\";s:1:\"1\";s:8:\"dArquivo\";s:1:\"1\";s:8:\"vArquivo\";s:1:\"1\";s:11:\"aLancamento\";s:1:\"1\";s:11:\"eLancamento\";s:1:\"0\";s:11:\"dLancamento\";s:1:\"0\";s:11:\"vLancamento\";s:1:\"1\";s:8:\"cUsuario\";s:1:\"0\";s:9:\"cEmitente\";s:1:\"0\";s:10:\"cPermissao\";s:1:\"0\";s:7:\"cBackup\";s:1:\"0\";s:10:\"cAuditoria\";s:1:\"0\";s:6:\"cEmail\";s:1:\"0\";s:8:\"cSistema\";s:1:\"0\";s:8:\"rCliente\";s:1:\"0\";s:8:\"rProduto\";s:1:\"0\";s:8:\"rServico\";s:1:\"0\";s:3:\"rOs\";s:1:\"1\";s:6:\"rVenda\";s:1:\"0\";s:11:\"rFinanceiro\";s:1:\"0\";s:9:\"aCobranca\";s:1:\"0\";s:9:\"eCobranca\";s:1:\"0\";s:9:\"dCobranca\";s:1:\"0\";s:9:\"vCobranca\";s:1:\"0\";}', 1, '2026-01-24');
INSERT INTO `permissoes` (`idPermissao`, `nome`, `permissoes`, `situacao`, `data`) VALUES (3, 'Financeiro', 'a:49:{s:8:\"aCliente\";s:1:\"1\";s:8:\"eCliente\";s:1:\"1\";s:8:\"dCliente\";s:1:\"0\";s:8:\"vCliente\";s:1:\"1\";s:8:\"aProduto\";s:1:\"0\";s:8:\"eProduto\";s:1:\"0\";s:8:\"dProduto\";s:1:\"0\";s:8:\"vProduto\";s:1:\"1\";s:8:\"aServico\";s:1:\"0\";s:8:\"eServico\";s:1:\"0\";s:8:\"dServico\";s:1:\"0\";s:8:\"vServico\";s:1:\"1\";s:3:\"aOs\";s:1:\"0\";s:3:\"eOs\";s:1:\"0\";s:3:\"dOs\";s:1:\"0\";s:3:\"vOs\";s:1:\"1\";s:6:\"aVenda\";s:1:\"0\";s:6:\"eVenda\";s:1:\"1\";s:6:\"dVenda\";s:1:\"0\";s:6:\"vVenda\";s:1:\"1\";s:9:\"aGarantia\";s:1:\"0\";s:9:\"eGarantia\";s:1:\"0\";s:9:\"dGarantia\";s:1:\"0\";s:9:\"vGarantia\";s:1:\"0\";s:8:\"aArquivo\";s:1:\"1\";s:8:\"eArquivo\";s:1:\"1\";s:8:\"dArquivo\";s:1:\"0\";s:8:\"vArquivo\";s:1:\"1\";s:11:\"aLancamento\";s:1:\"1\";s:11:\"eLancamento\";s:1:\"1\";s:11:\"dLancamento\";s:1:\"1\";s:11:\"vLancamento\";s:1:\"1\";s:8:\"cUsuario\";s:1:\"0\";s:9:\"cEmitente\";s:1:\"0\";s:10:\"cPermissao\";s:1:\"0\";s:7:\"cBackup\";s:1:\"0\";s:10:\"cAuditoria\";s:1:\"0\";s:6:\"cEmail\";s:1:\"0\";s:8:\"cSistema\";s:1:\"0\";s:8:\"rCliente\";s:1:\"1\";s:8:\"rProduto\";s:1:\"0\";s:8:\"rServico\";s:1:\"0\";s:3:\"rOs\";s:1:\"1\";s:6:\"rVenda\";s:1:\"1\";s:11:\"rFinanceiro\";s:1:\"1\";s:9:\"aCobranca\";s:1:\"1\";s:9:\"eCobranca\";s:1:\"1\";s:9:\"dCobranca\";s:1:\"1\";s:9:\"vCobranca\";s:1:\"1\";}', 1, '2026-01-24');


#
# TABLE STRUCTURE FOR: produtos
#

DROP TABLE IF EXISTS `produtos`;

CREATE TABLE `produtos` (
  `idProdutos` int NOT NULL AUTO_INCREMENT,
  `codDeBarra` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `unidade` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precoCompra` decimal(10,2) DEFAULT NULL,
  `precoVenda` decimal(10,2) NOT NULL,
  `estoque` int NOT NULL,
  `estoqueMinimo` int DEFAULT NULL,
  `saida` tinyint(1) DEFAULT NULL,
  `entrada` tinyint(1) DEFAULT NULL,
  `marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modelo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idProdutos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: produtos_os
#

DROP TABLE IF EXISTS `produtos_os`;

CREATE TABLE `produtos_os` (
  `idProdutos_os` int NOT NULL AUTO_INCREMENT,
  `quantidade` int NOT NULL,
  `descricao` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT '0.00',
  `os_id` int NOT NULL,
  `produtos_id` int NOT NULL,
  `subTotal` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`idProdutos_os`),
  KEY `fk_produtos_os_os1` (`os_id`),
  KEY `fk_produtos_os_produtos1` (`produtos_id`),
  CONSTRAINT `fk_produtos_os_os1` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`),
  CONSTRAINT `fk_produtos_os_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`idProdutos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: resets_de_senha
#

DROP TABLE IF EXISTS `resets_de_senha`;

CREATE TABLE `resets_de_senha` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_expiracao` datetime NOT NULL,
  `token_utilizado` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: servicos
#

DROP TABLE IF EXISTS `servicos`;

CREATE TABLE `servicos` (
  `idServicos` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idServicos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: servicos_os
#

DROP TABLE IF EXISTS `servicos_os`;

CREATE TABLE `servicos_os` (
  `idServicos_os` int NOT NULL AUTO_INCREMENT,
  `servico` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `quantidade` double DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT '0.00',
  `os_id` int NOT NULL,
  `servicos_id` int NOT NULL,
  `subTotal` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`idServicos_os`),
  KEY `fk_servicos_os_os1` (`os_id`),
  KEY `fk_servicos_os_servicos1` (`servicos_id`),
  CONSTRAINT `fk_servicos_os_os1` FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`),
  CONSTRAINT `fk_servicos_os_servicos1` FOREIGN KEY (`servicos_id`) REFERENCES `servicos` (`idServicos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# TABLE STRUCTURE FOR: site_config
#

DROP TABLE IF EXISTS `site_config`;

CREATE TABLE `site_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(100) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `sobre` text,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `horario_funcionamento` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `cor_primaria` varchar(7) DEFAULT '#007bff',
  `cor_secundaria` varchar(7) DEFAULT '#6c757d',
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `google_analytics` text,
  `meta_description` text,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `imagem_inicio` varchar(255) DEFAULT NULL,
  `imagem_sobre` varchar(255) DEFAULT NULL,
  `texto_inicio` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

INSERT INTO `site_config` (`id`, `nome_empresa`, `slogan`, `sobre`, `telefone`, `email`, `endereco`, `horario_funcionamento`, `logo`, `favicon`, `cor_primaria`, `cor_secundaria`, `facebook`, `instagram`, `whatsapp`, `google_analytics`, `meta_description`, `meta_keywords`, `imagem_inicio`, `imagem_sobre`, `texto_inicio`) VALUES (1, 'Map-OS', 'Sistema de Gestão de Assistência Técnica', '', '', '', '', '', 'logo.png', NULL, '#007bff', '#6c757d', '', '', '', NULL, '', '', NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: site_contatos
#

DROP TABLE IF EXISTS `site_contatos`;

CREATE TABLE `site_contatos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `assunto` varchar(100) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `lido` tinyint(1) DEFAULT '0',
  `respondido` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# TABLE STRUCTURE FOR: site_depoimentos
#

DROP TABLE IF EXISTS `site_depoimentos`;

CREATE TABLE `site_depoimentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `depoimento` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `avaliacao` int DEFAULT '5',
  `ativo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

#
# TABLE STRUCTURE FOR: site_paginas
#

DROP TABLE IF EXISTS `site_paginas`;

CREATE TABLE `site_paginas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `conteudo` text,
  `ordem` int DEFAULT '0',
  `ativo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `imagem_capa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

INSERT INTO `site_paginas` (`id`, `titulo`, `slug`, `conteudo`, `ordem`, `ativo`, `created_at`, `meta_description`, `meta_keywords`, `imagem_capa`) VALUES (1, 'Sobre Nós', 'sobre-nos', '<h2>Quem Somos</h2><p>Somos uma empresa dedicada a entregar a melhor solução para você. Nossa missão é otimizar seu tempo e melhorar o seu dia a dia.</p>', 1, 1, '2026-03-19 18:11:44', NULL, NULL, NULL);
INSERT INTO `site_paginas` (`id`, `titulo`, `slug`, `conteudo`, `ordem`, `ativo`, `created_at`, `meta_description`, `meta_keywords`, `imagem_capa`) VALUES (2, 'Política de Privacidade', 'politica-de-privacidade', '<h2>Sua Privacidade</h2><p>Garantimos sigilo absoluto sobre os dados aqui trafegados, de acordo com as diretrizes e leis de proteção vigentes.</p>', 2, 1, '2026-03-19 18:11:44', NULL, NULL, NULL);
INSERT INTO `site_paginas` (`id`, `titulo`, `slug`, `conteudo`, `ordem`, `ativo`, `created_at`, `meta_description`, `meta_keywords`, `imagem_capa`) VALUES (3, 'Termos de Serviço', 'termos-de-servico', '<h2>Nossos Termos</h2><p>Ao utilizar os serviços de nossa empresa, você concorda com os termos e regras expostos aqui.</p>', 3, 1, '2026-03-19 18:11:44', NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: site_servicos
#

DROP TABLE IF EXISTS `site_servicos`;

CREATE TABLE `site_servicos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `descricao` text,
  `icone` varchar(50) DEFAULT NULL,
  `ordem` int DEFAULT '0',
  `ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

INSERT INTO `site_servicos` (`id`, `titulo`, `descricao`, `icone`, `ordem`, `ativo`) VALUES (1, 'Manutenção de Hardware', 'Reparo especializado em placas, troca de componentes e limpeza avançada.', 'bx-chip', 1, 1);
INSERT INTO `site_servicos` (`id`, `titulo`, `descricao`, `icone`, `ordem`, `ativo`) VALUES (2, 'Soluções em Software', 'Melhoria de desempenho, formatação e instalação de sistemas corporativos.', 'bx-code-alt', 2, 1);
INSERT INTO `site_servicos` (`id`, `titulo`, `descricao`, `icone`, `ordem`, `ativo`) VALUES (3, 'Redes Corporativas', 'Estruturação, cabeamento e configuração de servidores seguros.', 'bx-network-chart', 3, 1);


#
# TABLE STRUCTURE FOR: usuarios
#

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idUsuarios` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rg` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cep` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rua` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `celular` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `situacao` tinyint(1) NOT NULL,
  `dataCadastro` date NOT NULL,
  `permissoes_id` int NOT NULL,
  `dataExpiracao` date DEFAULT NULL,
  `url_image_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`idUsuarios`),
  KEY `fk_usuarios_permissoes1_idx` (`permissoes_id`),
  CONSTRAINT `fk_usuarios_permissoes1` FOREIGN KEY (`permissoes_id`) REFERENCES `permissoes` (`idPermissao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`idUsuarios`, `nome`, `rg`, `cpf`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `email`, `senha`, `telefone`, `celular`, `situacao`, `dataCadastro`, `permissoes_id`, `dataExpiracao`, `url_image_user`) VALUES (1, 'administrador', 'MG-25.502.560', '600.021.520-87', '70005-115', 'Rua Acima', '12', 'Alvorada', 'Teste', 'MG', 'admin@admin.com', '$2y$12$FWfsomaVazqd8WT1Tq803ujrOb1.xggWlia68d6iHEUMnPsBFPKYm', '000000-0000', '', 1, '2026-01-19', 1, '3000-01-01', NULL);
INSERT INTO `usuarios` (`idUsuarios`, `nome`, `rg`, `cpf`, `cep`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `email`, `senha`, `telefone`, `celular`, `situacao`, `dataCadastro`, `permissoes_id`, `dataExpiracao`, `url_image_user`) VALUES (2, 'Tecnico Teste', '123456789', '123.456.789-09', '01234-567', 'Rua Teste', '123', 'Bairro Teste', 'Cidade Teste', 'SP', 'tecnico@teste.com', '$2y$12$BduaaQkA5llsUFB3RN4lC.iNaA6mA.w3Z8w6T0Sz4N9FWrNwlXm/.', '(11) 99999-9999', '', 1, '2026-01-25', 1, '2030-12-31', NULL);


#
# TABLE STRUCTURE FOR: vendas
#

DROP TABLE IF EXISTS `vendas`;

CREATE TABLE `vendas` (
  `idVendas` int NOT NULL AUTO_INCREMENT,
  `dataVenda` date DEFAULT NULL,
  `valorTotal` decimal(10,2) DEFAULT '0.00',
  `desconto` decimal(10,2) DEFAULT '0.00',
  `valor_desconto` decimal(10,2) DEFAULT '0.00',
  `tipo_desconto` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `faturado` tinyint(1) DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `observacoes_cliente` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `clientes_id` int NOT NULL,
  `usuarios_id` int DEFAULT NULL,
  `caixa_id` int DEFAULT NULL,
  `lancamentos_id` int DEFAULT NULL,
  `status` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `garantia` int DEFAULT NULL,
  `forma_pgto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Dinheiro',
  PRIMARY KEY (`idVendas`),
  KEY `fk_vendas_clientes1` (`clientes_id`),
  KEY `fk_vendas_usuarios1` (`usuarios_id`),
  KEY `fk_vendas_lancamentos1` (`lancamentos_id`),
  CONSTRAINT `fk_vendas_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`idClientes`),
  CONSTRAINT `fk_vendas_lancamentos1` FOREIGN KEY (`lancamentos_id`) REFERENCES `lancamentos` (`idLancamentos`),
  CONSTRAINT `fk_vendas_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

