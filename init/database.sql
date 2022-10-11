CREATE DATABASE IF NOT EXISTS cashconvertersefraindb;
USE cashconvertersefraindb;

-- Doctrine migration versions

CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
    `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
    `executed_at` datetime DEFAULT NULL,
    `execution_time` int DEFAULT NULL,
    PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20221010183727','2022-10-10 18:39:01',403);

-- User

CREATE TABLE IF NOT EXISTS `user` (
    `id` int NOT NULL AUTO_INCREMENT,
    `email` varchar(180) COLLATE utf8mb3_unicode_ci NOT NULL,
    `roles` json NOT NULL,
    `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `user` VALUES
(1,'admin@admin.es','[\"ROLE_ADMIN\"]','$2y$13$ULodsPVmqCML0OmocgSkCOjalCIc.j1r01VFRF2pUos./ghdV18pS'),
(2,'efrain@efrain.es','[\"ROLE_USER\"]','$2y$13$TLAVZJ4a6VPLOhGruaY.0OI2L/ISHfFRj14AgrTr.QonvXjmG3ID.');

-- Status

CREATE TABLE IF NOT EXISTS `status` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `description` varchar(50) DEFAULT NULL,
    `class_name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `status` VALUES
(1, 'Enabled', 'Enabled / Visible', 'text-success'),
(2, 'Disabled', 'Disabled / Not visible', 'text-danger');

-- Question type

CREATE TABLE IF NOT EXISTS `question_type` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `value` varchar(50) NOT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `question_type` (`id`, `value`, `status_id`) VALUES
(1, 'input_text', 1),
(2, 'input_number', 1),
(3, 'select', 1),
(4, 'input_radio', 2);

-- Question

CREATE TABLE IF NOT EXISTS `question` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `question` (`id`, `name`, `status_id`) VALUES
(1, 'Brand', 1),
(2, 'Model', 1),
(3, 'Title', 1),
(4, 'Platform', 1),
(5, 'EAN', 1),
(6, 'IMEI', 1),
(7, 'ISBN', 2);

-- Category

CREATE TABLE IF NOT EXISTS `category` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` VARCHAR(50) DEFAULT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id`, `name`, `description`, `status_id`) VALUES
(1, 'Smartphone', 'Smartphone', 1),
(2, 'Consola', 'Consola', 1),
(3, 'Videojuego', 'Videojuego', 1),
(4, 'Televisor de tubo', 'Televisor de tubo', 2);

-- Category question

CREATE TABLE IF NOT EXISTS `category_question` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `category_id` int unsigned NOT NULL,
    `question_id` int unsigned NOT NULL,
    `position` int unsigned NOT NULL,
    `required` tinyint NOT NULL DEFAULT 1,
    `question_type_id` int unsigned NOT NULL,
    `values_entity` VARCHAR(50) DEFAULT NULL,
    `values_entity_dependence` VARCHAR(50) DEFAULT NULL,
    `placeholder` VARCHAR(50) DEFAULT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)
        REFERENCES category(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`question_id`)
        REFERENCES question(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`question_type_id`)
        REFERENCES question_type(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category_question` (`id`, `category_id`, `question_id`, `position`, `required`, `question_type_id`, `values_entity`, `values_entity_dependence`, `placeholder`, `status_id`) VALUES
-- Smartphone
(2, 1, 1, 2, 1, 3, 'brand', NULL, '-- Select brand for Smartphone --', 1),
(3, 1, 2, 3, 1, 3, 'model', 'brand', '-- Select model for Smartphone --', 1),
(4, 1, 3, 1, 0, 1, NULL, NULL, 'eg: Samsung Galaxy S9 rosa', 1),
(5, 1, 6, 4, 1, 2, NULL, NULL, 'eg: 454571392555927 (15 digits)', 1),
-- Consola
(6, 2, 1, 1, 1, 3, 'brand', NULL, '-- Select brand for Consola --', 1),
(7, 2, 2, 2, 1, 3, 'model', 'brand', '-- Select model for Consola --', 1),
(8, 2, 3, 3, 0, 1, NULL, NULL, 'eg: Playstation 2 blanca', 1),
-- Videojuego
(9, 3, 3, 2, 1, 1, NULL, NULL, 'eg: Fifa 2021', 1),
(10, 3, 4, 3, 1, 3, 'platform', NULL, '-- Select platform for Videojuego --', 1),
(11, 3, 5, 1, 0, 2, NULL, NULL, 'eg: 9780201379624 (13 digits)', 1),
-- Televisor de tubo
(12, 4, 3, 1, 1, 1, NULL, NULL, 'eg: Televisor Philips 29PT5458/01', 1);

-- Brand

CREATE TABLE IF NOT EXISTS `brand` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    /*
    * 'category_id' solo se tendrá en cuenta cuando una 'category_question' tenga como 'values_entity' = 'brand',
    * para seleccionar solo los registros de 'brand' asociados a esa 'category_id'
    */
    `category_id` int unsigned DEFAULT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)
        REFERENCES category(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `brand` (`id`, `name`, `category_id`, `status_id`) VALUES
(1, 'LG', 1, 1),
(2, 'Samsung', 1, 1),
(3, 'PS2', 2, 1),
(4, 'PS3', 2, 1),
(5, 'PS1', 2, 2);

-- Model

CREATE TABLE IF NOT EXISTS `model` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `brand_id` int unsigned NOT NULL,
    /*
    * 'category_id' solo se tendrá en cuenta cuando una 'category_question' tenga como 'values_entity' = 'model',
    * para seleccionar solo los registros de 'model' asociados a esa 'category_id'
    */
    `category_id` int unsigned DEFAULT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`brand_id`)
        REFERENCES brand(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`category_id`)
        REFERENCES category(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `model` (`id`, `name`, `brand_id`, `category_id`, `status_id`) VALUES
(1, 'LG 2', 1, NULL, 1),
(2, 'LG 3', 1, NULL, 1),
(3, 'Galaxy S9', 2, NULL, 1),
(4, 'Galaxy S10', 2, NULL, 1),
(5, 'PS2 Fat', 3, NULL, 1),
(6, 'PS2 Slim', 3, NULL, 1),
(7, 'PS2 Slim (Descatalogada)', 3, NULL, 2),
(8, 'PS3 Fat', 4, NULL, 1),
(9, 'PS3 Slim', 4, NULL, 1),
(10, 'PS1 Fat', 5, NULL, 2),
(11, 'PS1 Slim', 5, NULL, 2);

-- Platform

CREATE TABLE IF NOT EXISTS `platform` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(50) NOT NULL,
    `description` varchar(50) NOT NULL,
    /*
    * 'category_id' solo se tendrá en cuenta cuando una 'category_question' tenga como 'values_entity' = 'platform',
    * para seleccionar solo los registros de 'platform' asociados a esa 'category_id'
    */
    `category_id` int unsigned DEFAULT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`)
        REFERENCES category(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `platform` (`id`, `name`, `description`, `category_id`, `status_id`) VALUES
(1, 'PlayStation® 2', 'PS2', NULL, 1),
(2, 'PlayStation® 3', 'PS3', NULL, 1),
(3, 'PlayStation®', 'PS1', NULL, 2);

-- Product

CREATE TABLE IF NOT EXISTS product (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `brand_id` int unsigned DEFAULT NULL, -- Smartphone, Consola
    `model_id` int unsigned DEFAULT NULL, -- Smartphone, Consola
    `title` VARCHAR(50) DEFAULT NULL, -- All
    `platform_id` int unsigned DEFAULT NULL, -- Videojuego
    `ean` bigint(13) DEFAULT NULL, -- Videojuego
    `imei` bigint(15) DEFAULT NULL, -- Smartphone (15 digits)
    `category_id` int unsigned NOT NULL,
    `status_id` int unsigned NOT NULL DEFAULT 1,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`brand_id`)
        REFERENCES brand(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`model_id`)
        REFERENCES model(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`category_id`)
        REFERENCES category(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`platform_id`)
        REFERENCES platform(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (`status_id`)
        REFERENCES status(`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `product` (`brand_id`, `model_id`, `title`, `platform_id`, `ean`, `imei`, `category_id`, `status_id`) VALUES
(1, 1, 'LG 2 Mini Rosa', NULL, NULL, 865858058912150, 1, 1),
(1, 2, 'LG 3 Max Pro', NULL, NULL, 353903100989332, 1, 1),
(2, 3, 'Smartphone', NULL, NULL, 865858054348276, 1, 1),
(2, 4, 'Smartphone', NULL, NULL, 353903109792448, 1, 1),
(3, 5, 'Pley 2 con lector dañado', NULL, NULL, NULL, 2, 1),
(3, 6, 'ps2 slim blanca', NULL, NULL, NULL, 2, 1),
(4, 7, 'PS3 con disco duro', NULL, NULL, NULL, 2, 1),
(4, 8, 'Ps3 fina edición COD', NULL, NULL, NULL, 2, 1),
(5, 9, 'PS1 chipeada', NULL, NULL, NULL, 2, 1),
(5, 10, 'play1 de las finas', NULL, NULL, NULL, 2, 2),
(NULL, NULL, 'Final Fantasy X', 1, 9780201379624, NULL, 3, 2);
