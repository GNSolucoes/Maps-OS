-- Tabelas para Sistema de Compras

-- Tabela principal de compras
CREATE TABLE IF NOT EXISTS `compras` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `numero_compra` VARCHAR(50) UNIQUE,
    `fornecedor_id` INT NOT NULL,
    `data_compra` DATE NOT NULL,
    `data_entrega` DATE,
    `status` ENUM(
        'orcamento',
        'aprovado',
        'pedido',
        'recebido',
        'cancelado'
    ) DEFAULT 'orcamento',
    `valor_total` DECIMAL(10, 2) DEFAULT 0,
    `desconto` DECIMAL(10, 2) DEFAULT 0,
    `frete` DECIMAL(10, 2) DEFAULT 0,
    `observacoes` TEXT,
    `usuario_id` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`fornecedor_id`) REFERENCES `clientes` (`idClientes`),
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de itens da compra
CREATE TABLE IF NOT EXISTS `compras_itens` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `compra_id` INT NOT NULL,
    `produto_id` INT NOT NULL,
    `quantidade` INT NOT NULL,
    `preco_unitario` DECIMAL(10, 2) NOT NULL,
    `subtotal` DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`idProdutos`)
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Tabela de pagamentos da compra (contas a pagar)
CREATE TABLE IF NOT EXISTS `compras_pagamentos` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `compra_id` INT NOT NULL,
    `lancamento_id` INT,
    `valor` DECIMAL(10, 2) NOT NULL,
    `data_vencimento` DATE NOT NULL,
    `data_pagamento` DATE,
    `status` ENUM(
        'pendente',
        'pago',
        'atrasado'
    ) DEFAULT 'pendente',
    `forma_pagamento` VARCHAR(50),
    `observacoes` TEXT,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`lancamento_id`) REFERENCES `lancamentos` (`idLancamentos`) ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;