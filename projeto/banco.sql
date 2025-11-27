CREATE SCHEMA IF NOT EXISTS `projetofinanceiro` DEFAULT CHARACTER SET utf8 ;
USE `projetofinanceiro` ;

-- -----------------------------------------------------
-- RF: Autenticação (Tabela `usuario`)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetofinanceiro`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `senha` TEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- RF1: Tabela `conta` (Contas Bancárias/Carteiras)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetofinanceiro`.`conta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `saldo_inicial` DECIMAL(10,2) NOT NULL DEFAULT 0.00, -- Saldo inicial da conta
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_conta_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_conta_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `projetofinanceiro`.`usuario` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- RF2: Tabela `categoria_despesa` (Tipos de Gastos)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetofinanceiro`.`categoria_despesa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_categoria_despesa_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_categoria_despesa_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `projetofinanceiro`.`usuario` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- RF3: Tabela `fonte_renda` (Origens de Receita)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetofinanceiro`.`fonte_renda` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fonte_renda_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_fonte_renda_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `projetofinanceiro`.`usuario` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- RF4: Tabela `movimentacao` (Transações - Receitas e Despesas)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `projetofinanceiro`.`movimentacao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` ENUM('receita', 'despesa') NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `data_movimentacao` DATE NOT NULL,
  `descricao` VARCHAR(255) NULL,
  
  -- Relações
  `conta_id` INT NOT NULL,
  `categoria_despesa_id` INT NULL, -- NULL se for RECEITA
  `fonte_renda_id` INT NULL,        -- NULL se for DESPESA
  `usuario_id` INT NOT NULL,
  
  PRIMARY KEY (`id`),
  INDEX `fk_movimentacao_conta_idx` (`conta_id` ASC),
  INDEX `fk_movimentacao_cat_despesa_idx` (`categoria_despesa_id` ASC),
  INDEX `fk_movimentacao_fonte_renda_idx` (`fonte_renda_id` ASC),
  INDEX `fk_movimentacao_usuario_idx` (`usuario_id` ASC),
  
  CONSTRAINT `fk_movimentacao_conta`
    FOREIGN KEY (`conta_id`)
    REFERENCES `projetofinanceiro`.`conta` (`id`),
  CONSTRAINT `fk_movimentacao_cat_despesa`
    FOREIGN KEY (`categoria_despesa_id`)
    REFERENCES `projetofinanceiro`.`categoria_despesa` (`id`),
  CONSTRAINT `fk_movimentacao_fonte_renda`
    FOREIGN KEY (`fonte_renda_id`)
    REFERENCES `projetofinanceiro`.`fonte_renda` (`id`),
  CONSTRAINT `fk_movimentacao_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `projetofinanceiro`.`usuario` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;

