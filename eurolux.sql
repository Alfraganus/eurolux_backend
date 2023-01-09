-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 09, 2023 at 02:51 PM
-- Server version: 8.0.24
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eurolux`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Символьный код',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Активность',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название категории',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Описание',
  `created_at` int DEFAULT NULL COMMENT 'Дата создания',
  `updated_at` int DEFAULT NULL COMMENT 'Дата обновления',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `slug`, `is_active`, `title`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'test', 1, 'test', 'test', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int NOT NULL,
  `group_code` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Для группировки однотипных файлов. Например, news, banners',
  `object_id` int DEFAULT NULL COMMENT 'Уникальный идетификатор сущности для доп. группировки файлов',
  `object_type` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Дополнительная идентификация типа файла',
  `ori_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Оригинальное имя файла',
  `ori_extension` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Расширение файла',
  `sys_file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Системное имя файла',
  `mime` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'MIME-тип файла',
  `size` int UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Размер файла в байтах',
  `created_at` int NOT NULL COMMENT 'Дата сохранения файла',
  `updated_at` int NOT NULL COMMENT 'Дата обновления информации о файле'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `group_code`, `object_id`, `object_type`, `ori_name`, `ori_extension`, `sys_file`, `mime`, `size`, `created_at`, `updated_at`) VALUES
(9, 'category-icon', 10, NULL, '313004069_5820958781316582_7632223244951482464_n.jpg', 'jpg', 'category-icon/10/636cea0de949e.jpg', 'image/jpeg', 108123, 1668082190, 1668082190),
(10, 'category-icon', 10, NULL, '1.png', 'png', 'category-icon/10/636cea21366bd.png', 'image/png', 60030, 1668082209, 1668082209),
(11, 'category-icon', 5, NULL, '1659002903941.jpg', 'jpg', 'category-icon/5/638b1e3390601.jpg', 'image/jpeg', 25457, 1670061619, 1670061619);

-- --------------------------------------------------------

--
-- Table structure for table `media_asset`
--

CREATE TABLE `media_asset` (
  `id` int NOT NULL,
  `model_class` varchar(100) DEFAULT NULL,
  `source_table` varchar(50) NOT NULL,
  `object_id` int NOT NULL,
  `asset_name` varchar(255) NOT NULL,
  `asset_extension` varchar(20) DEFAULT NULL,
  `asset_path` varchar(255) DEFAULT NULL,
  `asset_mime` varchar(50) DEFAULT NULL,
  `asset_size` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `media_asset`
--

INSERT INTO `media_asset` (`id`, `model_class`, `source_table`, `object_id`, `asset_name`, `asset_extension`, `asset_path`, `asset_mime`, `asset_size`) VALUES
(20, 'common\\modules\\category\\models\\Category', 'category', 62, '20221114_2009491670240691.jpg', 'jpg', 'https://s3.timeweb.com/co21603-bucket-project-time-to-exchange/category-images/20221114_2009491670240691.jpg', 'image/jpeg', 235548);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('common\\modules\\category\\migrations\\m221102_140450_create_category_and_sub_category_tables', 1668424937),
('common\\modules\\publication\\migrations\\m221114_093125_add_publication_table', 1668682156),
('common\\modules\\publication\\migrations\\m221206_131226_add_user_id_to_publicaiton_table', 1670332512),
('common\\modules\\users\\migrations\\m221012_134658_create_customer_table', 1667299066),
('common\\modules\\users\\migrations\\m221101_092408_rename_customer_table', 1667299066),
('common\\modules\\users\\migrations\\m221101_111514_change_table_collations', 1667305367),
('common\\modules\\users\\migrations\\m221101_135413_create_user_auth_table', 1667373720),
('common\\modules\\users\\migrations\\m221107_054650_add_additional_info_tu_users_tabe', 1667806991),
('common\\modules\\users\\migrations\\m221107_122546_change_token_column_in_users_table', 1667824125),
('common\\modules\\users\\migrations\\m221122_072304_adde_gps_locatorss_to_userstable', 1669102904),
('common\\modules\\users\\migrations\\m221125_064244_make_lat_lng_optional', 1669718076),
('m130524_201442_init', 1667299066),
('m190124_110200_add_verification_token_column_to_user_table', 1667299066),
('m201026_111558_user_table_add_is_admin_field', 1667299066),
('m221029_111130_create_file_table', 1667998793),
('m221030_132010_extend_file_table', 1667998793),
('m221102_140450_create_category_and_sub_category_tables', 1667999231),
('m221204_114855_create_media_assets_table', 1670155146);

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `sub_category_id` int NOT NULL,
  `link_video` varchar(255) DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `location` varchar(300) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tariff_id` int DEFAULT NULL,
  `is_mutually_surcharged` tinyint NOT NULL,
  `is_active` tinyint DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`id`, `category_id`, `sub_category_id`, `link_video`, `title`, `description`, `price`, `location`, `latitude`, `longitude`, `tariff_id`, `is_mutually_surcharged`, `is_active`, `user_id`) VALUES
(2, 1, 1, 'test', 'test2', 'test', 10, 'test', 10, 11, NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `publication_exchange_category`
--

CREATE TABLE `publication_exchange_category` (
  `id` int NOT NULL,
  `publication_id` int NOT NULL,
  `reaction_type` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `sub_category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `publication_exchange_category`
--

INSERT INTO `publication_exchange_category` (`id`, `publication_id`, `reaction_type`, `category_id`, `sub_category_id`) VALUES
(1, 2, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `publication_images`
--

CREATE TABLE `publication_images` (
  `id` int NOT NULL,
  `publication_id` int NOT NULL,
  `is_main_image` int DEFAULT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `publication_reactions`
--

CREATE TABLE `publication_reactions` (
  `id` int NOT NULL,
  `publication_id` int NOT NULL,
  `user_id` int NOT NULL,
  `reaction_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `publication_tag`
--

CREATE TABLE `publication_tag` (
  `id` int NOT NULL,
  `publication_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `publication_tag`
--

INSERT INTO `publication_tag` (`id`, `publication_id`, `tag_id`) VALUES
(1, 2, 2),
(2, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `publication_tariff`
--

CREATE TABLE `publication_tariff` (
  `id` int NOT NULL,
  `quantity_days` int DEFAULT NULL,
  `price` float DEFAULT NULL,
  `start_date` int DEFAULT NULL,
  `end_date` int DEFAULT NULL,
  `is_free` float DEFAULT NULL,
  `is_active` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Символьный код',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Активность',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название подкатегории',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Описание',
  `created_at` int DEFAULT NULL COMMENT 'Дата создания',
  `updated_at` int DEFAULT NULL COMMENT 'Дата обновления',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `category_id`, `slug`, `is_active`, `title`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'test', 1, 'test', 'test', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'test'),
(2, 'test1'),
(3, 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_admin` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `is_admin`) VALUES
(1, 'admin', 'WcyfNlAXqYIPVOuhJCGNO-pD-9-pyBjg', '$2y$13$NIf95nfUoeGngAnP0V2GUOeNsx1jlRjnyxC.Tc9GkXXKPX8tKKNdO', NULL, 'admin@example.com', 10, 2022, 2022, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `is_active` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` int DEFAULT NULL COMMENT 'Дата создания',
  `updated_at` int DEFAULT NULL COMMENT 'Дата обновления',
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `region_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `search_radius` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_active`, `name`, `phone`, `created_at`, `updated_at`, `created_by`, `updated_by`, `email`, `city_id`, `region_id`, `country_id`, `latitude`, `longitude`, `search_radius`) VALUES
(1, 1, 'test', '12212', 1667312469, 1669807393, NULL, NULL, 'test@gmail.com', 4, NULL, NULL, 40.779544, 72.36703, 100000000),
(22, 1, 'wqe', '12313221', 1667913631, 1667913631, NULL, NULL, '', NULL, NULL, NULL, 0, 0, 0),
(23, 1, 'qwd', '1231322', 1667914134, 1667914134, NULL, NULL, 'qwd', NULL, NULL, NULL, 0, 0, 0),
(24, 1, 'wqd', '12313', 1667914907, 1667914907, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(25, 1, NULL, '1231354', 1667915326, 1667915326, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0),
(26, NULL, NULL, '9989990661123', 1669718422, 1669718422, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, '123123321', 1669807347, 1669807347, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `auth_key` varchar(64) NOT NULL,
  `ip_address` varchar(16) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `expired_at` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `user_id`, `auth_key`, `ip_address`, `user_agent`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'oyM5n5_6m5Ln_a1xvHcLJTA9F-YL9lRt', '', '', 1668001685, 1667397068, 1667915285),
(20, 22, 'YZZCls__CcUy_POBYMExD5uYwwWNSMyV', '', '', 1668000485, 1667913631, 1667914085),
(21, 23, '3D4Db8zaOD47rP1w1VLLQjginvGSSMw1', '', '', 1668001717, 1667914134, 1667915317),
(22, 24, 'nbEQl77QF_avJgp1I7tRqMqVmfgczP4W', '', '', 1668001318, 1667914907, 1667914918),
(23, 25, 'ELxOjYoW-k9r1tvxAQoJRHISRyWTJm34', '', '', 1668001740, 1667915326, 1667915340),
(24, 26, 'Hy5K_kOnuUCu4JloPAldc-Ue8lHCn0IK', '', '', 1669804822, 1669718422, 1669718422),
(25, 27, 'i4D-KP5qn1gX1Yr5yzqd7hCBKg356B9Y', '', '', 1669893747, 1669807347, 1669807347);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sys_file` (`sys_file`),
  ADD KEY `idx_file_group_code` (`group_code`),
  ADD KEY `idx_file_object_id` (`object_id`);

--
-- Indexes for table `media_asset`
--
ALTER TABLE `media_asset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-publication-category_id` (`category_id`,`sub_category_id`,`tariff_id`),
  ADD KEY `fk-publication-sub_category_id` (`sub_category_id`),
  ADD KEY `fk-publication-tariff_id` (`tariff_id`),
  ADD KEY `user_id_to_publication-foreign-key` (`user_id`);

--
-- Indexes for table `publication_exchange_category`
--
ALTER TABLE `publication_exchange_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-publication-publication_exchange_category` (`publication_id`),
  ADD KEY `fk-publication-publication_exchange_category_category` (`category_id`),
  ADD KEY `fk-publication-publication_exchange_sub_category` (`sub_category_id`);

--
-- Indexes for table `publication_images`
--
ALTER TABLE `publication_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-publication-images` (`publication_id`);

--
-- Indexes for table `publication_reactions`
--
ALTER TABLE `publication_reactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-publication-publication_reactions` (`user_id`),
  ADD KEY `fk-publication-publication_reactions_add` (`publication_id`);

--
-- Indexes for table `publication_tag`
--
ALTER TABLE `publication_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-publication-publication_tag` (`publication_id`),
  ADD KEY `fk-publication-publication_tag_id` (`tag_id`);

--
-- Indexes for table `publication_tariff`
--
ALTER TABLE `publication_tariff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk-sub_category-category` (`category_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token-index` (`auth_key`),
  ADD KEY `user_token-foreign-key` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `media_asset`
--
ALTER TABLE `media_asset`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `publication_exchange_category`
--
ALTER TABLE `publication_exchange_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `publication_images`
--
ALTER TABLE `publication_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publication_reactions`
--
ALTER TABLE `publication_reactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publication_tag`
--
ALTER TABLE `publication_tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `publication_tariff`
--
ALTER TABLE `publication_tariff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `fk-publication-category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-publication-sub_category_id` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-publication-tariff_id` FOREIGN KEY (`tariff_id`) REFERENCES `publication_tariff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_to_publication-foreign-key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publication_exchange_category`
--
ALTER TABLE `publication_exchange_category`
  ADD CONSTRAINT `fk-publication-publication_exchange_category` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-publication-publication_exchange_category_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-publication-publication_exchange_sub_category` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publication_images`
--
ALTER TABLE `publication_images`
  ADD CONSTRAINT `fk-publication-images` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publication_reactions`
--
ALTER TABLE `publication_reactions`
  ADD CONSTRAINT `fk-publication-publication_reactions` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-publication-publication_reactions_add` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `publication_tag`
--
ALTER TABLE `publication_tag`
  ADD CONSTRAINT `fk-publication-publication_tag` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-publication-publication_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `fk-sub_category-category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token-foreign-key` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
