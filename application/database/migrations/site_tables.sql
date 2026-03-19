-- Tabelas para Site Institucional

-- Configurações do site
CREATE TABLE IF NOT EXISTS `site_config` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome_empresa` VARCHAR(150),
    `slogan` VARCHAR(255),
    `sobre` TEXT,
    `telefone` VARCHAR(20),
    `email` VARCHAR(100),
    `endereco` TEXT,
    `horario_funcionamento` VARCHAR(255),
    `logo` VARCHAR(255),
    `favicon` VARCHAR(255),
    `cor_primaria` VARCHAR(7) DEFAULT '#007bff',
    `cor_secundaria` VARCHAR(7) DEFAULT '#6c757d',
    `facebook` VARCHAR(255),
    `instagram` VARCHAR(255),
    `whatsapp` VARCHAR(20),
    `google_analytics` TEXT,
    `meta_description` TEXT,
    `meta_keywords` TEXT,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Páginas do site
CREATE TABLE IF NOT EXISTS `site_paginas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(150) NOT NULL,
    `slug` VARCHAR(150) UNIQUE NOT NULL,
    `conteudo` LONGTEXT,
    `imagem_destaque` VARCHAR(255),
    `ordem` INT DEFAULT 0,
    `ativo` BOOLEAN DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Serviços oferecidos
CREATE TABLE IF NOT EXISTS `site_servicos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(150) NOT NULL,
    `descricao` TEXT,
    `icone` VARCHAR(50),
    `ordem` INT DEFAULT 0,
    `ativo` BOOLEAN DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Depoimentos
CREATE TABLE IF NOT EXISTS `site_depoimentos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `cargo` VARCHAR(100),
    `depoimento` TEXT NOT NULL,
    `foto` VARCHAR(255),
    `avaliacao` INT DEFAULT 5,
    `ativo` BOOLEAN DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Contatos recebidos
CREATE TABLE IF NOT EXISTS `site_contatos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefone` VARCHAR(20),
    `assunto` VARCHAR(150),
    `mensagem` TEXT NOT NULL,
    `lido` BOOLEAN DEFAULT 0,
    `respondido` BOOLEAN DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Inserir configuração padrão
INSERT INTO
    `site_config` (
        `id`,
        `nome_empresa`,
        `slogan`
    )
VALUES (
        1,
        'Map-OS',
        'Sistema de Gestão de Assistência Técnica'
    );