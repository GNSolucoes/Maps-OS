-- Tabelas para Sistema de Checklist

-- Tabela de templates de checklist
CREATE TABLE IF NOT EXISTS `checklist_templates` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `descricao` TEXT,
    `ativo` BOOLEAN DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de itens do checklist
CREATE TABLE IF NOT EXISTS `checklist_items` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `template_id` INT NOT NULL,
    `item` VARCHAR(200) NOT NULL,
    `ordem` INT DEFAULT 0,
    `obrigatorio` BOOLEAN DEFAULT 0,
    `permite_foto` BOOLEAN DEFAULT 1,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`template_id`) REFERENCES `checklist_templates` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de checklist aplicado em OS
CREATE TABLE IF NOT EXISTS `checklist_os` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `os_id` INT NOT NULL,
    `template_id` INT NOT NULL,
    `data_preenchimento` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `usuario_id` INT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`os_id`) REFERENCES `os` (`idOs`) ON DELETE CASCADE,
    FOREIGN KEY (`template_id`) REFERENCES `checklist_templates` (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de respostas do checklist
CREATE TABLE IF NOT EXISTS `checklist_respostas` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `checklist_os_id` INT NOT NULL,
    `item_id` INT NOT NULL,
    `status` ENUM('ok', 'nao_ok', 'na') DEFAULT 'na',
    `observacao` TEXT,
    `foto` VARCHAR(255),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`checklist_os_id`) REFERENCES `checklist_os` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`item_id`) REFERENCES `checklist_items` (`id`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;