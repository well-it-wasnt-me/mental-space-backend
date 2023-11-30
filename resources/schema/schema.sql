CREATE TABLE `access_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `os` text,
  `location` varchar(100) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `annotazioni` (
  `ann_id` int NOT NULL AUTO_INCREMENT,
  `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `annotazione` text,
  `doc_id` int DEFAULT NULL,
  `paz_id` int DEFAULT NULL,
  PRIMARY KEY (`ann_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `assegnazione_diagnosi` (
  `assd_id` int NOT NULL AUTO_INCREMENT,
  `paz_id` int DEFAULT NULL,
  `dsm_id` int DEFAULT NULL,
  PRIMARY KEY (`assd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `assegnazione_farmaci` (
  `id` int NOT NULL AUTO_INCREMENT,
  `farm_id` int DEFAULT NULL,
  `paz_id` int DEFAULT NULL,
  `data_assegnazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `oraPrimaDoseDoppia` varchar(5) DEFAULT NULL,
  `oraPrimaDoseSingola` varchar(5) DEFAULT NULL,
  `oraSecondaDoseDoppia` varchar(5) DEFAULT NULL,
  `scheduled` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `calendar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doc_id` int DEFAULT NULL,
  `paz_id` int DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `label` varchar(200) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `allDay` tinyint DEFAULT NULL,
  `event_url` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `comportamenti` (
  `cmp_id` int NOT NULL AUTO_INCREMENT,
  `paz_id` int DEFAULT NULL,
  `gesti_autolesivi` text,
  `tentativi_suicidio` text,
  `assunzione_alcol` text,
  `assunzione_droghe` text,
  `assunzione_farmaci` text,
  `abbuffate` text,
  `vomito` text,
  `data_compilazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cmp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `consulti` (
  `con_id` int NOT NULL AUTO_INCREMENT,
  `destinatario` varchar(200) DEFAULT NULL,
  `pin_code` varchar(16) DEFAULT NULL,
  `codice` varchar(44) DEFAULT NULL,
  `paz_id` int DEFAULT NULL,
  `stato` tinyint DEFAULT '1' COMMENT '0 = Inactive 1 = Attivo\n',
  `data_creazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`con_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `diaries` (
  `diary_id` int NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`diary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `doctors` (
  `doc_id` int NOT NULL AUTO_INCREMENT,
  `doc_name` varchar(35) NOT NULL,
  `doc_surname` varchar(45) NOT NULL,
  `doc_rag_soc` varchar(150) DEFAULT NULL,
  `doc_tel` varchar(20) DEFAULT NULL,
  `doc_photo` text,
  `doc_hourlyrate` int DEFAULT NULL,
  `doc_address` varchar(150) DEFAULT NULL,
  `doc_paypal` varchar(150) DEFAULT NULL,
  `doc_piva` varchar(11) DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `dsm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descrizione` text,
  `icd_nine` varchar(10) DEFAULT NULL,
  `icd_ten` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `emozioni` (
  `em_id` int NOT NULL AUTO_INCREMENT,
  `paz_id` int DEFAULT NULL,
  `doc_id` int DEFAULT NULL,
  `data_compilazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `rabbia` int DEFAULT NULL,
  `paura` int DEFAULT NULL,
  `gioia` int DEFAULT NULL,
  `colpa` int DEFAULT NULL,
  `tristezza` int DEFAULT NULL,
  `vergogna` int DEFAULT NULL,
  `sofferenza_fisica_emotiva` int DEFAULT NULL,
  `abilita_messe_in_pratica` int DEFAULT NULL,
  `intenzione_abbandono_terapia` int DEFAULT NULL,
  `fiducia_cambiamento` int DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`em_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `farmaci` (
  `id` int NOT NULL AUTO_INCREMENT,
  `principio_attivo` varchar(200) DEFAULT NULL,
  `descrizione_gruppo` varchar(200) DEFAULT NULL,
  `denom` varchar(200) DEFAULT NULL,
  `prezzo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `hack_attempt` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) DEFAULT NULL,
  `browser` text,
  `location` text,
  `other` text,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `icd` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codice` varchar(10) DEFAULT NULL,
  `descrizione` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `invoices` (
  `inv_id` int NOT NULL AUTO_INCREMENT,
  `paz_id` int DEFAULT NULL,
  `doc_id` int DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `amount_paid` int DEFAULT NULL,
  `payment_type` int DEFAULT NULL COMMENT '0 paypal 1 stripe 2 bonifico 3 cash',
  `data_issue` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_paid` timestamp NULL DEFAULT NULL,
  `inv_status` int DEFAULT NULL COMMENT '0 unpaid\n1 overdraft\n2 half paid\n3 paid\n',
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `messages` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `msg_from` int DEFAULT NULL,
  `msg_to` int DEFAULT NULL,
  `content` text,
  `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `read` tinyint DEFAULT '0' COMMENT '0 da leggere 1 letto',
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mood_trackings` (
  `trk_id` int NOT NULL AUTO_INCREMENT,
  `usr_id` int NOT NULL,
  `mood_id` int NOT NULL,
  `effective_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `warning_sign` text,
  PRIMARY KEY (`trk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `moods` (
  `mood_id` int NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  `slogan` text,
  `image` text,
  PRIMARY KEY (`mood_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `obiettivi` (
  `ob_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `obiettivo` text,
  `ts_obiettivo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `passi` (
  `pass_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `passi` int DEFAULT NULL,
  `data_inserimento` date DEFAULT NULL,
  PRIMARY KEY (`pass_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `patients` (
  `paz_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(75) NOT NULL,
  `dob` date DEFAULT NULL,
  `cf` varchar(16) DEFAULT NULL,
  `photo` text,
  `address` varchar(150) DEFAULT NULL,
  `height` int DEFAULT NULL,
  `weight` int DEFAULT NULL,
  `notes` text,
  `dsm_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `doc_id` int DEFAULT NULL,
  `data_inizio_cure` date DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `em_nome` varchar(150) DEFAULT NULL,
  `em_telefono` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`paz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `phq9` (
  `ph_id` int NOT NULL AUTO_INCREMENT,
  `paz_id` int DEFAULT NULL,
  `data_compilazione` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `interesse` tinyint DEFAULT NULL,
  `depresso` tinyint DEFAULT NULL,
  `difficolta_sonno` tinyint DEFAULT NULL,
  `stanco` tinyint DEFAULT NULL,
  `poca_fame` tinyint DEFAULT NULL,
  `sensi_di_colpa` tinyint DEFAULT NULL,
  `difficolta_concentrazione` tinyint DEFAULT NULL,
  `movimento` tinyint DEFAULT NULL,
  `meglio_morte` tinyint DEFAULT NULL,
  `difficolta_problemi` tinyint DEFAULT NULL,
  PRIMARY KEY (`ph_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `trackings` (
  `tracking_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `coords` text,
  `addr` text,
  `effective_data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tracking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `user_type` int NOT NULL COMMENT '1 Patient 2 Doctor 3 Admin',
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `account_status` int NOT NULL DEFAULT '0' COMMENT '0 to activate 1 active 2 suspended 3 deleted 4 Open to registration',
  `locale` varchar(5) DEFAULT 'it_IT',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `weight_trackings` (
  `wtrk_id` int NOT NULL AUTO_INCREMENT,
  `usr_id` int NOT NULL,
  `weight` int NOT NULL,
  `effective_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`wtrk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;