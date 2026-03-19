-- Tabelas para Sistema de Patrimônio

-- Tabela principal de patrimônios
CREATE TABLE IF NOT EXISTS `patrimonios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `codigo` VARCHAR(50) UNIQUE NOT NULL,
    `nome` VARCHAR(150) NOT NULL,
    `descricao` TEXT,
    `categoria` VARCHAR(50),
    `marca_id` INT,
    `modelo` VARCHAR(100),
    `num_serie` VARCHAR(100),
    `data_aquisicao` DATE,
    `valor_aquisicao` DECIMAL(10, 2),
    `fornecedor_id` INT,
    `localizacao` VARCHAR(100),
    `estado` ENUM(
        'novo',
        'bom',
        'regular',
        'ruim'
    ) DEFAULT 'bom',
    `status` ENUM(
        'ativo',
        'manutencao',
        'inativo',
        'baixado'
    ) DEFAULT 'ativo',
    `foto` VARCHAR(255),
    `observacoes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`idMarcas`) ON DELETE SET NULL,
    FOREIGN KEY (`fornecedor_id`) REFERENCES `clientes` (`idClientes`) ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de manutenções do patrimônio
CREATE TABLE IF NOT EXISTS `patrimonio_manutencoes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `patrimonio_id` INT NOT NULL,
    `data_manutencao` DATE NOT NULL,
    `tipo` ENUM('preventiva', 'corretiva') NOT NULL,
    `descricao` TEXT,
    `custo` DECIMAL(10, 2),
    `responsavel_id` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`patrimonio_id`) REFERENCES `patrimonios` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`responsavel_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;