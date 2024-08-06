/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80033
 Source Host           : localhost:3306
 Source Schema         : personel

 Target Server Type    : MySQL
 Target Server Version : 80033
 File Encoding         : 65001

 Date: 25/06/2024 00:22:01
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for companies
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` time DEFAULT '09:00:00',
  `end_time` time DEFAULT '18:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('ACTIVE','PASSIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `companies_owner_id_foreign` (`owner_id`),
  CONSTRAINT `companies_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of companies
-- ----------------------------
BEGIN;
INSERT INTO `companies` (`id`, `owner_id`, `name`, `title`, `logo`, `address`, `phone`, `start_time`, `end_time`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES (2, 54, 'Adstate', 'Adstate', 'companies/ALXvQF1tW5PrZmCHNEhzomvzXIRzgScL.svg', 'EĞİTİM MAH. ABDİBEY SK. KENT PLUS SITESI SİTESİ B BLOK  NO: 24B  İÇ KAPI NO: 414 Kadıköy/istanbul', '05434998586', '09:00:00', '18:00:00', '2024-06-20 17:43:58', '2024-06-20 18:17:35', NULL, 'ACTIVE');
COMMIT;

-- ----------------------------
-- Table structure for leave_requests
-- ----------------------------
DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE `leave_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `leave_type_id` int DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `comment` longtext,
  `person_replace_id` int DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `status` enum('APPROVED','WAITING','REJECTED') DEFAULT 'WAITING',
  `rejected_comment` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Records of leave_requests
-- ----------------------------
BEGIN;
INSERT INTO `leave_requests` (`id`, `user_id`, `company_id`, `leave_type_id`, `start_date`, `start_time`, `end_date`, `end_time`, `total`, `comment`, `person_replace_id`, `return_date`, `return_time`, `status`, `rejected_comment`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 54, 2, 2, '2024-06-25 00:00:00', '09:00:00', '2024-06-25 00:00:00', '18:00:00', 0.89, 'asdasda', NULL, '2024-06-25 00:00:00', '13:50:00', 'WAITING', NULL, '2024-06-24 01:51:23', '2024-06-24 01:51:23', NULL);
INSERT INTO `leave_requests` (`id`, `user_id`, `company_id`, `leave_type_id`, `start_date`, `start_time`, `end_date`, `end_time`, `total`, `comment`, `person_replace_id`, `return_date`, `return_time`, `status`, `rejected_comment`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 54, 2, 2, '2024-06-25 00:00:00', '09:00:00', '2024-06-25 00:00:00', '18:00:00', 0.89, 'asdasda', NULL, '2024-06-25 00:00:00', '13:50:00', 'WAITING', NULL, '2024-06-24 01:51:25', '2024-06-24 01:51:25', NULL);
INSERT INTO `leave_requests` (`id`, `user_id`, `company_id`, `leave_type_id`, `start_date`, `start_time`, `end_date`, `end_time`, `total`, `comment`, `person_replace_id`, `return_date`, `return_time`, `status`, `rejected_comment`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 57, 2, 2, '2024-06-25 00:00:00', '09:00:00', '2024-06-25 00:00:00', '18:00:00', 1.00, NULL, 54, '2024-06-27 00:00:00', '19:50:00', 'WAITING', NULL, '2024-06-24 16:52:07', '2024-06-24 16:52:07', NULL);
INSERT INTO `leave_requests` (`id`, `user_id`, `company_id`, `leave_type_id`, `start_date`, `start_time`, `end_date`, `end_time`, `total`, `comment`, `person_replace_id`, `return_date`, `return_time`, `status`, `rejected_comment`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 57, 2, 2, '2024-06-25 00:00:00', '09:00:00', '2024-06-25 00:00:00', '18:00:00', 1.00, 'asd adsa', 54, '2024-06-25 00:00:00', '19:01:00', 'WAITING', NULL, '2024-06-24 17:01:15', '2024-06-24 17:01:15', NULL);
COMMIT;

-- ----------------------------
-- Table structure for leave_types
-- ----------------------------
DROP TABLE IF EXISTS `leave_types`;
CREATE TABLE `leave_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('YEARLY','REQUEST','NONLIMIT') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'YEARLY',
  `gender` enum('MAN','WOMAN','ALL') COLLATE utf8mb4_unicode_ci DEFAULT 'ALL',
  `price_type` enum('FREE','PRICE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PRICE',
  `description` text COLLATE utf8mb4_unicode_ci,
  `days` int DEFAULT NULL,
  `status` enum('ACTIVE','PASSIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of leave_types
-- ----------------------------
BEGIN;
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 'Doğum Sonrası İzni', 'REQUEST', 'WOMAN', 'FREE', 'Talep halinde doğum izni süresi dolan çalışanlara altı (6) aya kadar ücretsiz izin verilebilir.', 180, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 'Vefat İzni', 'REQUEST', 'ALL', 'PRICE', 'Vefat izni üç (3) iş günüdür. Çalışan, birinci derece yakınlarının (eş, kardeş, çocuklar, anne veya babası) vefat etmesi halinde kullanabilir.', 3, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 'Süt İzni', 'NONLIMIT', 'WOMAN', 'PRICE', 'Doğum yapmış kadın çalışanın çocuğunu emzirebilmesi için tanınan izin türüdür.', NULL, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 'İş Arama İzni', 'NONLIMIT', 'ALL', 'PRICE', 'İşten ayrılacak çalışana yeni iş araması için verilen izin türü.', NULL, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 'Evlilik İzni', 'REQUEST', 'ALL', 'PRICE', 'Evlilik izni üç (3) iş günüdür ve çalışanın nikah tarihi itibariyle başlar.', 3, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, 'Doğum İzni', 'REQUEST', 'ALL', 'PRICE', 'Kadın işçilerin doğumdan önce 8 (sekiz) ve doğumdan sonra 8 (sekiz) hafta olmak üzere toplam 16 (on altı) haftalık süre için kullanabilecekleri izin türüdür.', 112, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (7, 'Askerlik İzni', 'REQUEST', 'MAN', 'FREE', 'Askerlik nedeniyle çalışanlara tanınan izin türüdür.', 21, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (8, 'Babalık İzni', 'REQUEST', 'MAN', 'PRICE', 'Çalışan, eşinin doğum yapması halinde, doğumun yapıldığı gün dahil olmak üzere beş (5) iş günü “Babalık İzni” kullanabilir.', 5, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (9, 'Hastalık İzni', 'YEARLY', 'ALL', 'PRICE', 'Hastalık nedeniyle alınan ve doktor raporu gerektiren izin türüdür.', 40, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (10, 'Ücretsiz İzin', 'NONLIMIT', 'ALL', 'FREE', 'İşveren ve işçi arasında anlaşmayla kullanılabilen ücretsiz izin türüdür.', NULL, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (11, 'Doğum Günü İzni', 'YEARLY', 'ALL', 'PRICE', 'Çalışanın doğum günlerinde verilen izin türüdür.', 1, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (12, 'Yıllık İzin', 'YEARLY', 'ALL', 'PRICE', 'Kıdem yılına göre hak edilen yasal dinlenme hakkını kapsamaktadır.', 14, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (13, 'Mazeret İzni', 'YEARLY', 'ALL', 'PRICE', 'İş ile alakalı olmayan çalışana ait kişisel ihtiyaçlar neticesinde alınan izin türüdür.', 5, 'ACTIVE', NULL, NULL, NULL);
INSERT INTO `leave_types` (`id`, `name`, `type`, `gender`, `price_type`, `description`, `days`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (14, 'Yol İzni', 'YEARLY', 'ALL', 'FREE', 'Yıllık izinlerini işyerinin bulunduğu yer haricinde bir yerde geçirecek olan çalışanlara bu durumu belgelemeleri durumunda toplam dört (4) gün ücretsiz izin verilebilir.', 4, 'ACTIVE', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2, '2023_09_26_212917_create_admins_table', 1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3, '2023_10_11_213821_create_queue_logs_table', 2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4, '2023_10_27_134522_create_sectors_table', 3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5, '2023_10_27_135206_add_language_to_sectors', 4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6, '2024_01_16_094353_create_permission_tables', 5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7, '2024_02_03_220157_create_failed_jobs_table', 6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8, '2024_06_13_224918_create_sessions_table', 7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9, '2024_06_17_213656_users', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10, '2024_06_17_214020_companies', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11, '2024_06_17_214341_users_foreign', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12, '2024_06_17_214356_company_foreign', 8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13, '2024_06_18_042227_leave_types', 9);
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`, `updated_at`, `deleted_at`) VALUES (15, 'ysosmanceyhan@gmail.com', 'M51gavs1Q9xRZ28td2MkcDMmJ2mA3ymBRNSfc0mp', '2024-06-24 19:13:49', '2024-06-24 19:13:49', NULL);
COMMIT;

-- ----------------------------
-- Table structure for payment_requests
-- ----------------------------
DROP TABLE IF EXISTS `payment_requests`;
CREATE TABLE `payment_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `payment_type` enum('ADVANCE_PAYMENT','EXPENDITURE','OVERTIME') DEFAULT 'ADVANCE_PAYMENT',
  `amount` decimal(13,2) DEFAULT NULL,
  `used_date` date DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `comment` longtext,
  `tax_rate` bigint DEFAULT NULL,
  `receipt_date` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `hour` bigint DEFAULT NULL,
  `minute` bigint DEFAULT NULL,
  `status` enum('APPROVED','WAITING','REJECTED') DEFAULT 'WAITING',
  `payment_status` enum('APPROVED','WAITING','REJECTED') DEFAULT 'WAITING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Records of payment_requests
-- ----------------------------
BEGIN;
INSERT INTO `payment_requests` (`id`, `company_id`, `user_id`, `payment_type`, `amount`, `used_date`, `attachment`, `comment`, `tax_rate`, `receipt_date`, `start_date`, `start_time`, `hour`, `minute`, `status`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (14, 2, 57, 'EXPENDITURE', NULL, '2024-06-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'WAITING', 'WAITING', '2024-06-24 16:42:19', '2024-06-24 16:42:19', NULL);
INSERT INTO `payment_requests` (`id`, `company_id`, `user_id`, `payment_type`, `amount`, `used_date`, `attachment`, `comment`, `tax_rate`, `receipt_date`, `start_date`, `start_time`, `hour`, `minute`, `status`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (15, 2, 57, 'EXPENDITURE', 500.00, NULL, NULL, 'qd qwdqwq', 0, '2024-06-25', NULL, NULL, NULL, NULL, 'WAITING', 'WAITING', '2024-06-24 16:43:42', '2024-06-24 16:43:42', NULL);
INSERT INTO `payment_requests` (`id`, `company_id`, `user_id`, `payment_type`, `amount`, `used_date`, `attachment`, `comment`, `tax_rate`, `receipt_date`, `start_date`, `start_time`, `hour`, `minute`, `status`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (16, 2, 57, 'OVERTIME', NULL, NULL, NULL, 'asdads dasdas a', NULL, NULL, '2024-06-25', '09:00:00', 1, 0, 'WAITING', 'WAITING', '2024-06-24 16:49:06', '2024-06-24 16:49:06', NULL);
INSERT INTO `payment_requests` (`id`, `company_id`, `user_id`, `payment_type`, `amount`, `used_date`, `attachment`, `comment`, `tax_rate`, `receipt_date`, `start_date`, `start_time`, `hour`, `minute`, `status`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES (17, 2, 57, 'ADVANCE_PAYMENT', 500.00, '2024-06-25', NULL, 'asdadas', NULL, NULL, NULL, NULL, NULL, NULL, 'WAITING', 'WAITING', '2024-06-24 16:50:32', '2024-06-24 16:50:32', NULL);
COMMIT;

-- ----------------------------
-- Table structure for user_infos
-- ----------------------------
DROP TABLE IF EXISTS `user_infos`;
CREATE TABLE `user_infos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `contract_type` enum('INDEFINITE_CONTRACT','TERM_CONTRACT') DEFAULT 'INDEFINITE_CONTRACT',
  `end_date` date DEFAULT NULL,
  `work_type` enum('PART_TIME','FULL_TIME') DEFAULT 'FULL_TIME',
  `birthdate` date DEFAULT NULL,
  `tc_number` bigint DEFAULT NULL,
  `military_status` enum('DONE','POSTPONEMENT','LEAKAGE','EXEMPT') DEFAULT 'POSTPONEMENT',
  `military_done_date` date DEFAULT NULL,
  `military_postponement_date` date DEFAULT NULL,
  `educational_status` enum('STUDENT','GRADUATE') DEFAULT 'GRADUATE',
  `education_complete_status` enum('PRIMARY_SCHOOL','MIDDLE_SCHOOL','HIGH_SCHOOL','ASSOCIATE_DEGREE','UNIVERSITY','DOCTORATE') DEFAULT 'HIGH_SCHOOL',
  `marital_status` enum('MARRIED','SINGLE') DEFAULT 'SINGLE',
  `children_count` int DEFAULT '0',
  `adress` varchar(255) DEFAULT NULL,
  `adress_two` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `address_phone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_type` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `bank_iban` varchar(255) DEFAULT NULL,
  `bank_number` int DEFAULT NULL,
  `emergency_fullname` varchar(255) DEFAULT NULL,
  `emergency_phone` varchar(255) DEFAULT NULL,
  `emergency_proximity_degree` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- ----------------------------
-- Records of user_infos
-- ----------------------------
BEGIN;
INSERT INTO `user_infos` (`id`, `user_id`, `company_id`, `title`, `start_date`, `contract_type`, `end_date`, `work_type`, `birthdate`, `tc_number`, `military_status`, `military_done_date`, `military_postponement_date`, `educational_status`, `education_complete_status`, `marital_status`, `children_count`, `adress`, `adress_two`, `city`, `country`, `zip_code`, `address_phone`, `bank_name`, `bank_type`, `bank_iban`, `bank_number`, `emergency_fullname`, `emergency_phone`, `emergency_proximity_degree`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 54, 54, 'Owner', '2024-06-21', 'INDEFINITE_CONTRACT', NULL, 'FULL_TIME', '2024-06-12', NULL, 'POSTPONEMENT', NULL, NULL, 'GRADUATE', 'HIGH_SCHOOL', 'SINGLE', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `user_infos` (`id`, `user_id`, `company_id`, `title`, `start_date`, `contract_type`, `end_date`, `work_type`, `birthdate`, `tc_number`, `military_status`, `military_done_date`, `military_postponement_date`, `educational_status`, `education_complete_status`, `marital_status`, `children_count`, `adress`, `adress_two`, `city`, `country`, `zip_code`, `address_phone`, `bank_name`, `bank_type`, `bank_iban`, `bank_number`, `emergency_fullname`, `emergency_phone`, `emergency_proximity_degree`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 57, 2, 'Software Developer', '2024-06-20', 'INDEFINITE_CONTRACT', NULL, 'PART_TIME', '2024-06-12', 37528761144, 'POSTPONEMENT', NULL, NULL, 'GRADUATE', 'HIGH_SCHOOL', 'SINGLE', 0, NULL, NULL, NULL, 'Turkey', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-24 12:05:06', '2024-06-24 15:05:44', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_role` enum('ADMIN','MANAGER','EMPLOYEE') COLLATE utf8mb4_unicode_ci DEFAULT 'EMPLOYEE',
  `company_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verify_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('MAN','WOMAN','EMPTY') COLLATE utf8mb4_unicode_ci DEFAULT 'EMPTY',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employees_count` int DEFAULT NULL,
  `status` enum('ACTIVE','PASSIVE','NONVERIFY','DEMO','CANCELLED','BANNED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`email`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_company_id_foreign` (`company_id`),
  CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` (`id`, `user_role`, `company_id`, `name`, `surname`, `avatar`, `email`, `verify_token`, `gender`, `email_verified_at`, `password`, `phone`, `company_name`, `company_title`, `employees_count`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (54, 'MANAGER', 2, 'Osman', 'Ceyhan', NULL, 'ysosmanceyhan@gmail.com', NULL, 'EMPTY', NULL, '$2y$10$mUd3rbPk8w1mJ8HaxjGpHeHQiQmrQg9a.7HZnaDCo95a6VZn7Jjnu', '05434998586', 'Adstate', 'Adstate', 15, 'DEMO', '2024-06-20 17:43:58', '2024-06-25 00:21:01', NULL);
INSERT INTO `users` (`id`, `user_role`, `company_id`, `name`, `surname`, `avatar`, `email`, `verify_token`, `gender`, `email_verified_at`, `password`, `phone`, `company_name`, `company_title`, `employees_count`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES (57, 'EMPLOYEE', 2, 'Mehmet', 'Mehmet', 'avatar/B9mdlGdALu44y17boQLTz8GzdCUj82ss.jpg', 'mehmet@mehmet.com', NULL, 'MAN', NULL, '$2y$10$oSMnfKQAnCZyDJW3p4xG0ekJCuQk497xaSrHimRomt8wMZ76RJ.DS', '05434998586', NULL, NULL, NULL, 'ACTIVE', '2024-06-24 12:05:06', '2024-06-25 00:21:01', NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
