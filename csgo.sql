SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `csgo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `csgo` ;

-- -----------------------------------------------------
-- Table `csgo`.`user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `csgo`.`user` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `username` VARCHAR(24) NOT NULL,
    `password` VARCHAR(16) NOT NULL,
    UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
    PRIMARY KEY (`id`) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `csgo`.`search`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `csgo`.`search` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `username` VARCHAR(24) NOT NULL,
    `photo` VARCHAR(128) NOT NULL,
    `country` VARCHAR(48) NOT NULL,
    `name` VARCHAR(48) NOT NULL,
    `nick` VARCHAR(48) NOT NULL,
    `kills` INT,
    `death` INT,
    `win` INT,
    UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
    PRIMARY KEY (`id`) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `csgo`.`comparison`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `csgo`.`comparison` (
    `id` INT NOT NULL AUTO_INCREMENT, 
    `username` VARCHAR(24) NOT NULL,
    `photo1` VARCHAR(128) NOT NULL,
    `country1` VARCHAR(48) NOT NULL,
    `name1` VARCHAR(48) NOT NULL,
    `nick1` VARCHAR(48) NOT NULL,
    `kill1` INT NOT NULL,
    `death1` INT NOT NULL,
    `win1` INT NOT NULL,
    `photo2` VARCHAR(128) NOT NULL,
    `country2` VARCHAR(48) NOT NULL,
    `name2` VARCHAR(48) NOT NULL,
    `nick2` VARCHAR(48) NOT NULL,
    `kill2` INT NOT NULL,
    `death2` INT NOT NULL,
    `win2` INT NOT NULL,
    UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
    PRIMARY KEY (`id`) )
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
