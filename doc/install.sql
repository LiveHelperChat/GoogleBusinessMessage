CREATE TABLE `lhc_google_business_agent` (
                                             `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                             `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                             `verify_token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                             `client_token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                             `dep_id` bigint(20) unsigned NOT NULL,
                                             `brand_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                             `agent_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                                             PRIMARY KEY (`id`),
                                             KEY `client_token` (`client_token`),
                                             KEY `agent_id` (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;