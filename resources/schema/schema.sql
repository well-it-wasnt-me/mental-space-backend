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

CREATE TABLE `annotation` (
                            `ann_id` int NOT NULL AUTO_INCREMENT,
                            `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                            `annotation` text,
                            `doc_id` int DEFAULT NULL,
                            `paz_id` int DEFAULT NULL,
                            PRIMARY KEY (`ann_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `assignment_diagnosis` (
                                      `assd_id` int NOT NULL AUTO_INCREMENT,
                                      `paz_id` int DEFAULT NULL,
                                      `dsm_id` int DEFAULT NULL,
                                      PRIMARY KEY (`assd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `drugs_assignment` (
                                  `id` int NOT NULL AUTO_INCREMENT,
                                  `farm_id` int DEFAULT NULL,
                                  `paz_id` int DEFAULT NULL,
                                  `assignment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                                  `hourFirstDoubleDose` varchar(5) DEFAULT NULL,
                                  `hourFirstSingleDose` varchar(5) DEFAULT NULL,
                                  `hourSecondDoubleDose` varchar(5) DEFAULT NULL,
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

CREATE TABLE `behaviours` (
                            `cmp_id` int NOT NULL AUTO_INCREMENT,
                            `paz_id` int DEFAULT NULL,
                            `selfharm_acts` text,
                            `suicidal_attempts` text,
                            `alcohol_use` text,
                            `assunzione_droghe` text,
                            `illegal_drug_use` text,
                            `binge_eating` text,
                            `puking` text,
                            `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`cmp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `consults` (
                          `con_id` int NOT NULL AUTO_INCREMENT,
                          `recipient` varchar(200) DEFAULT NULL,
                          `pin_code` varchar(16) DEFAULT NULL,
                          `code` varchar(44) DEFAULT NULL,
                          `paz_id` int DEFAULT NULL,
                          `state` tinyint DEFAULT '1' COMMENT '0 = Inactive 1 = Attivo\n',
                          `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
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
                     `description` text,
                     `icd_nine` varchar(10) DEFAULT NULL,
                     `icd_ten` varchar(10) DEFAULT NULL,
                     PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `emotions` (
                          `em_id` int NOT NULL AUTO_INCREMENT,
                          `paz_id` int DEFAULT NULL,
                          `doc_id` int DEFAULT NULL,
                          `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                          `rage` int DEFAULT NULL,
                          `afraid` int DEFAULT NULL,
                          `joy` int DEFAULT NULL,
                          `guilt` int DEFAULT NULL,
                          `sadness` int DEFAULT NULL,
                          `shame` int DEFAULT NULL,
                          `physical_emotional_suffering` int DEFAULT NULL,
                          `abilities_put_into_practice` int DEFAULT NULL,
                          `intention_leave_therapy` int DEFAULT NULL,
                          `trust_into_changing` int DEFAULT NULL,
                          `note` text,
                          PRIMARY KEY (`em_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `drugs` (
                       `id` int NOT NULL AUTO_INCREMENT,
                       `active_principle` varchar(200) DEFAULT NULL,
                       `group_description` varchar(200) DEFAULT NULL,
                       `denom` varchar(200) DEFAULT NULL,
                       `price` varchar(200) DEFAULT NULL,
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
                     `code` varchar(10) DEFAULT NULL,
                     `description` text,
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
                          `read` tinyint DEFAULT '0' COMMENT '0 to read 1 read',
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

CREATE TABLE `objectives` (
                            `ob_id` int NOT NULL AUTO_INCREMENT,
                            `user_id` int DEFAULT NULL,
                            `obiettivo` text,
                            `ts_obiettivo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                            PRIMARY KEY (`ob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `steps` (
                       `pass_id` int NOT NULL AUTO_INCREMENT,
                       `user_id` int DEFAULT NULL,
                       `steps` int DEFAULT NULL,
                       `data_insert` date DEFAULT NULL,
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
                      `submission_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                      `interest` tinyint DEFAULT NULL,
                      `depressed` tinyint DEFAULT NULL,
                      `sleep_difficulty` tinyint DEFAULT NULL,
                      `tired` tinyint DEFAULT NULL,
                      `notso_hungry` tinyint DEFAULT NULL,
                      `sense_of_guilt` tinyint DEFAULT NULL,
                      `trouble_concentrating` tinyint DEFAULT NULL,
                      `movement` tinyint DEFAULT NULL,
                      `better_dead` tinyint DEFAULT NULL,
                      `propblems_difficulty` tinyint DEFAULT NULL,
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