-- MySQL Script for recoltePure Database (Corrected)
-- Compatible with XAMPP / MySQL 8+
-- Author: khushi gajjar
-- Date: 2025-10-21

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE;
SET SQL_MODE='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema recoltePure
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `recoltePure` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `recoltePure`;

-- -----------------------------------------------------
-- Table: farmer
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `farmer` (
  `farmer_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100),
  `email` VARCHAR(100),
  `phone_number` VARCHAR(15),
  `address` VARCHAR(255),
  `certificate_number` VARCHAR(45),
  `verification_date` DATE,
  `registration_date` DATETIME,
  `password_hash` VARCHAR(255),
  PRIMARY KEY (`farmer_id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: Users
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Users` (
  `customer_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100),
  `email` VARCHAR(100),
  `address` VARCHAR(255),
  `password` VARCHAR(255),
  `registration_date` DATETIME,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: delivery
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `delivery` (
  `delivery_id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT,
  `delivery_date` DATE,
  `delivery_status` VARCHAR(45),
  `delivery_partner` VARCHAR(100),
  `tracking_number` VARCHAR(45),
  PRIMARY KEY (`delivery_id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: order_or_cart
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_or_cart` (
  `customer_id` INT NOT NULL,
  `delivery_id` INT NOT NULL,
  `announce_id` INT,
  PRIMARY KEY (`customer_id`, `delivery_id`),
  INDEX `fk_order_delivery1_idx` (`delivery_id`),
  CONSTRAINT `fk_order_delivery1`
    FOREIGN KEY (`delivery_id`)
    REFERENCES `delivery` (`delivery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: payment
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT,
  `payment_date` DATE,
  `payment_method` VARCHAR(45),
  `payment_status` VARCHAR(45),
  `transaction_reference_id` VARCHAR(45),
  `order_customer_id` INT NOT NULL,
  `order_delivery_id` INT NOT NULL,
  PRIMARY KEY (`payment_id`),
  INDEX `fk_payment_order1_idx` (`order_customer_id`, `order_delivery_id`),
  CONSTRAINT `fk_payment_order1`
    FOREIGN KEY (`order_customer_id`, `order_delivery_id`)
    REFERENCES `order_or_cart` (`customer_id`, `delivery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: Categories
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Categories` (
  `category_id` INT NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(100),
  `category_description` VARCHAR(255),
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: Product
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Product` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `farmer_id` INT,
  `category_id` INT,
  `product_name` VARCHAR(100),
  `price` DECIMAL(10,2),
  `stock_quantity` INT,
  PRIMARY KEY (`product_id`),
  INDEX `fk_Product_Categories1_idx` (`category_id`),
  CONSTRAINT `fk_Product_Categories1`
    FOREIGN KEY (`category_id`)
    REFERENCES `Categories` (`category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Product_farmer1`
    FOREIGN KEY (`farmer_id`)
    REFERENCES `farmer` (`farmer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: certificate
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `certificate` (
  `certificate_id` INT NOT NULL AUTO_INCREMENT,
  `certificate_name` VARCHAR(100),
  `farmer_id` INT,
  PRIMARY KEY (`certificate_id`),
  INDEX `fk_certificate_farmer_idx` (`farmer_id`),
  CONSTRAINT `fk_certificate_farmer`
    FOREIGN KEY (`farmer_id`)
    REFERENCES `farmer` (`farmer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: Announcement
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Announcement` (
  `announce_id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `farmer_id` INT NOT NULL,
  `announcement_date` DATE,
  PRIMARY KEY (`announce_id`),
  INDEX `fk_Announcement_Product_idx` (`product_id`),
  INDEX `fk_Announcement_farmer_idx` (`farmer_id`),
  CONSTRAINT `fk_Announcement_Product`
    FOREIGN KEY (`product_id`)
    REFERENCES `Product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Announcement_farmer`
    FOREIGN KEY (`farmer_id`)
    REFERENCES `farmer` (`farmer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: order_items
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `announcement_id` INT NOT NULL,
  `order_customer_id` INT NOT NULL,
  `order_delivery_id` INT NOT NULL,
  `quantity` INT DEFAULT 1,
  PRIMARY KEY (`announcement_id`, `order_customer_id`, `order_delivery_id`),
  INDEX `fk_orderitems_order_idx` (`order_customer_id`, `order_delivery_id`),
  CONSTRAINT `fk_orderitems_announcement`
    FOREIGN KEY (`announcement_id`)
    REFERENCES `Announcement` (`announce_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orderitems_order`
    FOREIGN KEY (`order_customer_id`, `order_delivery_id`)
    REFERENCES `order_or_cart` (`customer_id`, `delivery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table: Reviews
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Reviews` (
  `review_id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT NOT NULL,
  `order_customer_id` INT NOT NULL,
  `order_delivery_id` INT NOT NULL,
  `rating` INT,
  `comment` VARCHAR(255),
  `review_date` DATE,
  PRIMARY KEY (`review_id`),
  INDEX `fk_Reviews_order_idx` (`order_customer_id`, `order_delivery_id`),
  CONSTRAINT `fk_Reviews_order`
    FOREIGN KEY (`order_customer_id`, `order_delivery_id`)
    REFERENCES `order_or_cart` (`customer_id`, `delivery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Restore SQL Modes
-- -----------------------------------------------------
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
