CREATE TABLE `contact` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `subject` varchar(255) DEFAULT NULL,
    `message` text DEFAULT NULL,
    `active` tinyint(4) NOT NULL DEFAULT '1',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 0 DEFAULT CHARSET = latin1
