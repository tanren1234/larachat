/*
 Navicat Premium Data Transfer

 Source Server         : docker_mysql
 Source Server Type    : MySQL
 Source Server Version : 50725
 Source Host           : 127.0.0.1:33062
 Source Schema         : larchat

 Target Server Type    : MySQL
 Target Server Version : 50725
 File Encoding         : 65001

 Date: 10/10/2019 19:01:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `permission` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 1, 'Index', 'fa-bar-chart', '/', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (2, 0, 2, 'Admin', 'fa-tasks', '', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (3, 2, 3, 'Users', 'fa-users', 'auth/users', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (4, 2, 4, 'Roles', 'fa-user', 'auth/roles', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (5, 2, 5, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (6, 2, 6, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL, NULL);
INSERT INTO `admin_menu` VALUES (7, 2, 7, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_operation_log_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_operation_log
-- ----------------------------
INSERT INTO `admin_operation_log` VALUES (1, 1, 'admin', 'GET', '192.168.10.1', '[]', '2018-12-30 06:55:37', '2018-12-30 06:55:37');

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_menu_role_id_menu_id_index`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_permissions_role_id_permission_id_index`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_users_role_id_user_id_index`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2018-12-30 06:52:38', '2018-12-30 06:52:38');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions`  (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_user_permissions_user_id_permission_id_index`(`user_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$cYFomtBBaAXgbffvOiqESO.qY1CjDZqKCUBHnMPYYJvvETCFErtyK', 'Administrator', NULL, NULL, '2018-12-30 06:52:38', '2018-12-30 06:52:38');

-- ----------------------------
-- Table structure for im_conversation_groups
-- ----------------------------
DROP TABLE IF EXISTS `im_conversation_groups`;
CREATE TABLE `im_conversation_groups`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) NOT NULL COMMENT '群组id',
  `conversation_id` bigint(20) NOT NULL COMMENT '会话ID',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `conversation_groups_group_id_unique`(`group_id`) USING BTREE,
  UNIQUE INDEX `conversation_groups_conversation_id_unique`(`conversation_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_conversation_groups
-- ----------------------------
INSERT INTO `im_conversation_groups` VALUES (1, 1, 24, '2019-10-08 19:35:37', NULL);
INSERT INTO `im_conversation_groups` VALUES (2, 2, 25, '2019-10-08 20:14:47', NULL);

-- ----------------------------
-- Table structure for im_conversation_user
-- ----------------------------
DROP TABLE IF EXISTS `im_conversation_user`;
CREATE TABLE `im_conversation_user`  (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `conversation_id`) USING BTREE,
  INDEX `im_conversation_user_conversation_id_foreign`(`conversation_id`) USING BTREE,
  CONSTRAINT `im_conversation_user_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `im_conversations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `im_conversation_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_conversation_user
-- ----------------------------
INSERT INTO `im_conversation_user` VALUES (1, 13, '2019-09-19 07:53:32', '2019-09-19 07:53:32');
INSERT INTO `im_conversation_user` VALUES (1, 14, '2019-09-19 08:44:36', '2019-09-19 08:44:36');
INSERT INTO `im_conversation_user` VALUES (1, 15, '2019-09-20 06:59:10', '2019-09-20 06:59:10');
INSERT INTO `im_conversation_user` VALUES (1, 16, '2019-09-20 07:08:52', '2019-09-20 07:08:52');
INSERT INTO `im_conversation_user` VALUES (1, 17, '2019-09-20 08:10:21', '2019-09-20 08:10:21');
INSERT INTO `im_conversation_user` VALUES (1, 18, '2019-09-20 08:11:03', '2019-09-20 08:11:03');
INSERT INTO `im_conversation_user` VALUES (1, 19, '2019-09-20 08:20:12', '2019-09-20 08:20:12');
INSERT INTO `im_conversation_user` VALUES (1, 20, '2019-09-20 11:21:34', '2019-09-20 11:21:34');
INSERT INTO `im_conversation_user` VALUES (1, 21, '2019-09-20 11:23:42', '2019-09-20 11:23:42');
INSERT INTO `im_conversation_user` VALUES (1, 22, '2019-09-20 11:29:57', '2019-09-20 11:29:57');
INSERT INTO `im_conversation_user` VALUES (1, 23, '2019-09-20 11:30:56', '2019-09-20 11:30:56');
INSERT INTO `im_conversation_user` VALUES (2, 13, '2019-09-19 07:53:32', '2019-09-19 07:53:32');
INSERT INTO `im_conversation_user` VALUES (2, 14, '2019-09-19 08:44:36', '2019-09-19 08:44:36');
INSERT INTO `im_conversation_user` VALUES (2, 18, '2019-09-20 08:11:03', '2019-09-20 08:11:03');
INSERT INTO `im_conversation_user` VALUES (2, 19, '2019-09-20 08:20:12', '2019-09-20 08:20:12');
INSERT INTO `im_conversation_user` VALUES (2, 20, '2019-09-20 11:21:34', '2019-09-20 11:21:34');
INSERT INTO `im_conversation_user` VALUES (2, 21, '2019-09-20 11:23:42', '2019-09-20 11:23:42');
INSERT INTO `im_conversation_user` VALUES (2, 22, '2019-09-20 11:29:57', '2019-09-20 11:29:57');
INSERT INTO `im_conversation_user` VALUES (2, 23, '2019-09-20 11:30:56', '2019-09-20 11:30:56');

-- ----------------------------
-- Table structure for im_conversations
-- ----------------------------
DROP TABLE IF EXISTS `im_conversations`;
CREATE TABLE `im_conversations`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `private` tinyint(1) NOT NULL DEFAULT 1,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '会话类型，1：单聊 2：群聊',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_conversations
-- ----------------------------
INSERT INTO `im_conversations` VALUES (12, 1, '[]', '2019-09-19 07:51:42', '2019-09-19 07:51:42', 1);
INSERT INTO `im_conversations` VALUES (13, 1, '[]', '2019-09-19 07:53:32', '2019-09-19 07:53:32', 1);
INSERT INTO `im_conversations` VALUES (14, 1, '[]', '2019-09-19 08:44:36', '2019-09-19 08:44:36', 1);
INSERT INTO `im_conversations` VALUES (15, 1, '[]', '2019-09-20 06:59:10', '2019-09-20 06:59:10', 1);
INSERT INTO `im_conversations` VALUES (16, 1, '[]', '2019-09-20 07:08:52', '2019-09-20 07:08:52', 1);
INSERT INTO `im_conversations` VALUES (17, 1, '[]', '2019-09-20 08:10:21', '2019-09-20 08:10:21', 1);
INSERT INTO `im_conversations` VALUES (18, 1, '[]', '2019-09-20 08:11:03', '2019-09-20 08:11:03', 1);
INSERT INTO `im_conversations` VALUES (19, 1, '[]', '2019-09-20 08:20:12', '2019-09-20 08:20:12', 1);
INSERT INTO `im_conversations` VALUES (20, 1, '[]', '2019-09-20 11:21:34', '2019-09-20 11:21:34', 1);
INSERT INTO `im_conversations` VALUES (21, 1, '[]', '2019-09-20 11:23:42', '2019-09-20 11:23:42', 1);
INSERT INTO `im_conversations` VALUES (22, 1, '[]', '2019-09-20 11:29:57', '2019-09-20 11:29:57', 1);
INSERT INTO `im_conversations` VALUES (23, 1, '[]', '2019-09-20 11:30:56', '2019-09-20 11:30:56', 1);
INSERT INTO `im_conversations` VALUES (24, 1, '[]', '2019-10-08 19:36:01', '2019-10-08 19:36:04', 2);
INSERT INTO `im_conversations` VALUES (25, 1, '[]', '2019-10-08 20:14:32', '2019-10-08 20:14:35', 2);

-- ----------------------------
-- Table structure for im_group_users
-- ----------------------------
DROP TABLE IF EXISTS `im_group_users`;
CREATE TABLE `im_group_users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '用户id',
  `group_id` bigint(20) UNSIGNED NOT NULL COMMENT '群id',
  `user_group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户在群组的昵称',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `im_group_users_user_id_group_id_unique`(`user_id`, `group_id`) USING BTREE,
  INDEX `im_group_users_group_id_foreign`(`group_id`) USING BTREE,
  CONSTRAINT `im_group_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `im_groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `im_group_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_group_users
-- ----------------------------
INSERT INTO `im_group_users` VALUES (1, 1, 1, '谭仁', '2019-10-08 19:34:45', NULL);
INSERT INTO `im_group_users` VALUES (2, 2, 1, 'cs', '2019-10-08 19:34:57', NULL);
INSERT INTO `im_group_users` VALUES (3, 1, 2, 'qwe', '2019-10-08 20:12:39', NULL);

-- ----------------------------
-- Table structure for im_groups
-- ----------------------------
DROP TABLE IF EXISTS `im_groups`;
CREATE TABLE `im_groups`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '群组名称',
  `creator` bigint(20) UNSIGNED NOT NULL COMMENT '创建者',
  `qrcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '群二维码',
  `notice` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '群公告',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `im_groups_creator_index`(`creator`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_groups
-- ----------------------------
INSERT INTO `im_groups` VALUES (1, '测试', 1, '', NULL, '2019-09-25 19:46:20', NULL);
INSERT INTO `im_groups` VALUES (2, '群组1', 1, '', NULL, '2019-10-08 20:11:53', NULL);

-- ----------------------------
-- Table structure for im_message_notification
-- ----------------------------
DROP TABLE IF EXISTS `im_message_notification`;
CREATE TABLE `im_message_notification`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `is_sender` tinyint(1) NOT NULL DEFAULT 0,
  `flagged` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `is_send` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `im_message_notification_user_id_message_id_conversation_id_index`(`user_id`, `message_id`, `conversation_id`) USING BTREE,
  INDEX `im_message_notification_message_id_foreign`(`message_id`) USING BTREE,
  INDEX `im_message_notification_conversation_id_foreign`(`conversation_id`) USING BTREE,
  CONSTRAINT `im_message_notification_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `im_conversations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `im_message_notification_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `im_messages` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `im_message_notification_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_message_notification
-- ----------------------------
INSERT INTO `im_message_notification` VALUES (1, 2, 13, 1, 0, 0, 0, '2019-09-19 07:53:32', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (2, 2, 13, 2, 1, 1, 0, '2019-09-19 07:53:32', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (3, 3, 14, 1, 0, 0, 0, '2019-09-19 08:44:36', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (4, 3, 14, 2, 1, 1, 0, '2019-09-19 08:44:36', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (5, 4, 18, 1, 1, 1, 0, '2019-09-20 08:11:03', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (6, 4, 18, 2, 0, 0, 0, '2019-09-20 08:11:03', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (7, 5, 19, 1, 1, 1, 0, '2019-09-20 08:20:12', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (8, 5, 19, 2, 0, 0, 0, '2019-09-20 08:20:12', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (9, 6, 20, 1, 1, 1, 0, '2019-09-20 11:21:34', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (10, 6, 20, 2, 0, 0, 0, '2019-09-20 11:21:34', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (11, 7, 21, 1, 1, 1, 0, '2019-09-20 11:23:42', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (12, 7, 21, 2, 0, 0, 0, '2019-09-20 11:23:42', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (13, 8, 22, 1, 1, 1, 0, '2019-09-20 11:29:57', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (14, 8, 22, 2, 0, 0, 0, '2019-09-20 11:29:57', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (15, 9, 23, 1, 1, 1, 0, '2019-09-20 11:30:56', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (16, 9, 23, 2, 0, 0, 0, '2019-09-20 11:30:56', '2019-09-20 11:30:56', NULL, 1);
INSERT INTO `im_message_notification` VALUES (17, 11, 13, 1, 1, 1, 0, '2019-09-25 08:13:48', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (18, 11, 13, 2, 0, 0, 0, '2019-09-25 08:13:48', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (19, 12, 14, 1, 1, 1, 0, '2019-09-25 08:14:56', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (20, 12, 14, 2, 0, 0, 0, '2019-09-25 08:14:56', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (21, 13, 13, 1, 1, 1, 0, '2019-09-25 11:45:38', NULL, NULL, 0);
INSERT INTO `im_message_notification` VALUES (22, 13, 13, 2, 0, 0, 0, '2019-09-25 11:45:38', NULL, NULL, 0);

-- ----------------------------
-- Table structure for im_messages
-- ----------------------------
DROP TABLE IF EXISTS `im_messages`;
CREATE TABLE `im_messages`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `im_messages_conversation_id_user_id_index`(`conversation_id`, `user_id`) USING BTREE,
  INDEX `im_messages_user_id_foreign`(`user_id`) USING BTREE,
  CONSTRAINT `im_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `im_conversations` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `im_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of im_messages
-- ----------------------------
INSERT INTO `im_messages` VALUES (2, 'Hello', 13, 2, 'text', '2019-09-19 07:53:32', '2019-09-19 07:53:32');
INSERT INTO `im_messages` VALUES (3, 'Hello', 14, 2, 'text', '2019-09-19 08:44:36', '2019-09-19 08:44:36');
INSERT INTO `im_messages` VALUES (4, 'Hello', 18, 1, 'text', '2019-09-20 08:11:03', '2019-09-20 08:11:03');
INSERT INTO `im_messages` VALUES (5, 'Hello', 19, 1, 'text', '2019-09-20 08:20:12', '2019-09-20 08:20:12');
INSERT INTO `im_messages` VALUES (6, 'Hello2019-09-20 11:21:34', 20, 1, 'text', '2019-09-20 11:21:34', '2019-09-20 11:21:34');
INSERT INTO `im_messages` VALUES (7, 'Hello2019-09-20 11:23:42', 21, 1, 'text', '2019-09-20 11:23:42', '2019-09-20 11:23:42');
INSERT INTO `im_messages` VALUES (8, 'Hello2019-09-20 11:29:57', 22, 1, 'text', '2019-09-20 11:29:57', '2019-09-20 11:29:57');
INSERT INTO `im_messages` VALUES (9, 'Hello2019-09-20 11:30:56', 23, 1, 'text', '2019-09-20 11:30:56', '2019-09-20 11:30:56');
INSERT INTO `im_messages` VALUES (10, 'Hello2019-09-25 08:04:32', 13, 1, 'text', '2019-09-25 08:04:32', '2019-09-25 08:04:32');
INSERT INTO `im_messages` VALUES (11, 'Hello2019-09-25 08:13:48', 13, 1, 'text', '2019-09-25 08:13:48', '2019-09-25 08:13:48');
INSERT INTO `im_messages` VALUES (12, 'Hello2019-09-25 08:14:56', 14, 1, 'text', '2019-09-25 08:14:56', '2019-09-25 08:14:56');
INSERT INTO `im_messages` VALUES (13, 'Hello2019-09-25 11:45:38', 13, 1, 'text', '2019-09-25 11:45:38', '2019-09-25 11:45:38');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (4, '2016_06_01_000001_create_oauth_auth_codes_table', 2);
INSERT INTO `migrations` VALUES (5, '2016_06_01_000002_create_oauth_access_tokens_table', 2);
INSERT INTO `migrations` VALUES (6, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2);
INSERT INTO `migrations` VALUES (7, '2016_06_01_000004_create_oauth_clients_table', 2);
INSERT INTO `migrations` VALUES (8, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);
INSERT INTO `migrations` VALUES (13, '2019_01_05_071307_add_phone_to_users_table', 3);
INSERT INTO `migrations` VALUES (14, '2019_09_04_114847_create_chat_tables', 3);
INSERT INTO `migrations` VALUES (15, '2019_09_19_032104_add_is_send_to_im_message_notification_table', 4);
INSERT INTO `migrations` VALUES (16, '2019_09_20_120826_create_groups_table', 5);
INSERT INTO `migrations` VALUES (17, '2019_09_23_121650_create_conversation_groups_table', 6);

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_access_tokens_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------
INSERT INTO `oauth_access_tokens` VALUES ('1aa83ea4586c40af5300257113852dde15c9b4d6516e9f2211c20c6792376b4eb16a0c2a789059e1', 1, 2, NULL, '[]', 0, '2019-09-19 08:55:18', '2019-09-19 08:55:18', '2019-09-26 08:52:33');
INSERT INTO `oauth_access_tokens` VALUES ('1ad212172a5a1099f48ab4606630077b4930e18261280f9d01609434497c14476ca1e311ce9acc89', 2, 2, NULL, '[]', 0, '2019-03-01 07:10:10', '2019-03-01 07:10:10', '2019-03-08 07:10:10');
INSERT INTO `oauth_access_tokens` VALUES ('2f60a60ca8411904b06baafba313581e01043963166cb61ffc4eaa9d3ddfde63581ac9d602c70591', 2, 2, NULL, '[]', 0, '2019-10-08 07:38:22', '2019-10-08 07:38:22', '2019-10-15 07:36:40');
INSERT INTO `oauth_access_tokens` VALUES ('35363771a695727c1b05b35f5e2734ad64771aebacf7fbd52c174575d4ecc36a097667d5dac4d3d7', 2, 2, NULL, '[]', 0, '2019-01-20 08:39:27', '2019-01-20 08:39:27', '2019-01-27 08:39:27');
INSERT INTO `oauth_access_tokens` VALUES ('55e3ece882e4089b80c8142c5bffe7f2a6f093abacc4a7ed7a7511f952f3f5ecf1a94efb3987efb3', 2, 2, NULL, '[]', 0, '2019-06-19 23:54:01', '2019-06-19 23:54:01', '2019-06-26 23:54:01');
INSERT INTO `oauth_access_tokens` VALUES ('55e9ce90ee713e1b7e6108088e27ead5a505b82fd54f063a72249fd374a1f851ccf3887a0cec9fb9', 2, 2, NULL, '[]', 0, '2019-09-19 06:31:23', '2019-09-19 06:31:23', '2019-09-26 06:31:23');
INSERT INTO `oauth_access_tokens` VALUES ('59dc5909044d72eff8a257c48b4c953801cbec641f2784b8a99c07ab295468bc12881bf0d5ddca53', 1, 2, NULL, '[]', 0, '2019-01-10 14:30:08', '2019-01-10 14:30:08', '2019-01-17 14:30:08');
INSERT INTO `oauth_access_tokens` VALUES ('5a1aa6f0ac5fa1c28de00b856d2068e71045e01b4bc320ef247c6e1a320ac279c449232ae7dfa487', 2, 2, NULL, '[]', 0, '2019-10-07 09:46:13', '2019-10-07 09:46:13', '2019-10-14 09:46:11');
INSERT INTO `oauth_access_tokens` VALUES ('5bf426666782cab543d149f86d5861639442a5dac392ae938edbf72a6d2e2350b7b0afb3d0a6ecce', 2, 1, '2', '[]', 0, '2019-01-10 14:33:25', '2019-01-10 14:33:25', '2020-01-10 14:33:25');
INSERT INTO `oauth_access_tokens` VALUES ('602c39ac0bcbe5a5446b334bc4f1cca708e9e7a08d1c657ba788189eb9edb2d05215f9daa205b28a', 1, 1, '1', '[]', 0, '2019-01-08 14:26:58', '2019-01-08 14:26:58', '2020-01-08 14:26:58');
INSERT INTO `oauth_access_tokens` VALUES ('7883656beb6ec8b696bb65e213018f7a725fe3c8425b47c5d1ade705373bf1690af5455b7875806c', 2, 2, NULL, '[]', 0, '2019-09-03 06:46:52', '2019-09-03 06:46:52', '2019-09-10 06:46:52');
INSERT INTO `oauth_access_tokens` VALUES ('8cb154a7b77d16c74858e359e8a7b178df18c97826abfcf2a03658ea4b5b10ecbfd991ba64beaf10', 1, 2, NULL, '[]', 0, '2019-01-10 14:13:53', '2019-01-10 14:13:53', '2019-01-17 14:13:52');
INSERT INTO `oauth_access_tokens` VALUES ('8e629405924ace44ec4a1bedabaa5d8d2eb711a11b034449094f98a192123713bedeb208fa4c2d34', 2, 2, NULL, '[]', 0, '2019-09-20 08:19:22', '2019-09-20 08:19:22', '2019-09-27 08:10:20');
INSERT INTO `oauth_access_tokens` VALUES ('96b8b455bf1541a568b2b7e84e41c7f166bd571b2aec5d4f966e54955f083160599159d3d61cedb5', 2, 2, NULL, '[]', 0, '2019-03-01 10:22:25', '2019-03-01 10:22:25', '2019-03-08 10:22:25');
INSERT INTO `oauth_access_tokens` VALUES ('9c7cf0682f76c7d4d4437774d2acf6cb75270667ad9c0f42fc5002a5470f1cb978037afad23b050c', 1, 2, NULL, '[]', 0, '2019-01-10 14:23:06', '2019-01-10 14:23:06', '2019-01-17 14:23:06');
INSERT INTO `oauth_access_tokens` VALUES ('a1538675035e0ba5b04b4bdbf78ebca1c3198e0680ea0a2a34fda963e05b8fb1269105b849417b44', 2, 2, NULL, '[]', 0, '2019-09-19 08:54:41', '2019-09-19 08:54:41', '2019-09-26 08:51:56');
INSERT INTO `oauth_access_tokens` VALUES ('a6fa420fb6089427b1db9e1de087bc58fc9e7152bfba2642af673ae26db34b7a9549a772caec8952', 2, 2, NULL, '[]', 0, '2019-01-10 14:34:34', '2019-01-10 14:34:34', '2019-01-17 14:34:34');
INSERT INTO `oauth_access_tokens` VALUES ('c04ccac10f9a3561fb93a65d696483690e9d1955d9ebd7ea28ad9b117dd87d00ad7648afb08f27cb', 3, 1, '3', '[]', 0, '2019-01-08 14:23:52', '2019-01-08 14:23:52', '2020-01-08 14:23:52');
INSERT INTO `oauth_access_tokens` VALUES ('d492faa1a7e299064c22ae97bfb17fa14b0828d9fa2111dfadf212ecc652bd53199ab99db6d56a4e', 1, 2, NULL, '[]', 0, '2019-01-10 14:20:32', '2019-01-10 14:20:32', '2019-01-17 14:20:32');
INSERT INTO `oauth_access_tokens` VALUES ('e405d44db815daf0816332a31e50492f05860aa61b2adde468a07cb4774636b4074e822fb910514d', 1, 2, NULL, '[]', 0, '2019-09-09 09:42:00', '2019-09-09 09:42:00', '2019-09-09 09:44:00');
INSERT INTO `oauth_access_tokens` VALUES ('ebd02d4c0f3a172680210bfe10348d10b3798c4abd3c733b05dca6720a536de7f2481ccd16412792', 1, 2, NULL, '[]', 0, '2019-09-09 13:01:01', '2019-09-09 13:01:01', '2019-09-16 13:01:01');
INSERT INTO `oauth_access_tokens` VALUES ('f032c7c07bc92a51952df5c824f8f5faa9b7ba753732b79d5b69416c670d0616e4d1d6d8fbca1c1d', 1, 2, NULL, '[]', 0, '2019-09-09 03:28:09', '2019-09-09 03:28:09', '2019-09-16 03:28:09');

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_clients_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------
INSERT INTO `oauth_clients` VALUES (1, NULL, 'larchat Personal Access Client', 'eDS5TtcrRHP1iiSmGb6669GYfuS2UzJuFkNkSgPU', 'http://localhost', 1, 0, 0, '2019-01-05 05:57:13', '2019-01-05 05:57:13');
INSERT INTO `oauth_clients` VALUES (2, NULL, 'larchat Password Grant Client', 'EO5PIUxTsw1k5jnb0fcV0vu1g37uTiwiQYRltp0t', 'http://localhost', 0, 1, 0, '2019-01-05 05:57:13', '2019-01-05 05:57:13');

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS `oauth_personal_access_clients`;
CREATE TABLE `oauth_personal_access_clients`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_personal_access_clients_client_id_index`(`client_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_personal_access_clients
-- ----------------------------
INSERT INTO `oauth_personal_access_clients` VALUES (1, 1, '2019-01-05 05:57:13', '2019-01-05 05:57:13');

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens`  (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `oauth_refresh_tokens_access_token_id_index`(`access_token_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oauth_refresh_tokens
-- ----------------------------
INSERT INTO `oauth_refresh_tokens` VALUES ('072ed26b5edac337581251b6eb754945e5564521aa5ec737e8175635fc311629fb1e5a1667f4618d', '55e3ece882e4089b80c8142c5bffe7f2a6f093abacc4a7ed7a7511f952f3f5ecf1a94efb3987efb3', 0, '2019-07-03 23:54:01');
INSERT INTO `oauth_refresh_tokens` VALUES ('10a02d2cf835620af13f8f18f895cebafe383225b36e7d2222973d6e03a2f1687e6dfd36e3b38b99', '7883656beb6ec8b696bb65e213018f7a725fe3c8425b47c5d1ade705373bf1690af5455b7875806c', 0, '2019-09-17 06:46:52');
INSERT INTO `oauth_refresh_tokens` VALUES ('13312d5339f42fa934ceaafae2560aca13f4bde3cae206205f8a3d54393379b1ae44c0c606ee058e', 'e405d44db815daf0816332a31e50492f05860aa61b2adde468a07cb4774636b4074e822fb910514d', 0, '2019-09-23 09:42:00');
INSERT INTO `oauth_refresh_tokens` VALUES ('2055f6bd9a58697c4e49b6307f6c43c02317ba24107f414541e5ef89724cf72184054186ee63d8b2', '2f60a60ca8411904b06baafba313581e01043963166cb61ffc4eaa9d3ddfde63581ac9d602c70591', 0, '2019-10-22 07:36:40');
INSERT INTO `oauth_refresh_tokens` VALUES ('23f647fcf485ef165ce07adfa8ecd1e70239c04de0d5683219a66d9cc9da184211fbf0f56c3bf74d', '1aa83ea4586c40af5300257113852dde15c9b4d6516e9f2211c20c6792376b4eb16a0c2a789059e1', 0, '2019-10-03 08:52:33');
INSERT INTO `oauth_refresh_tokens` VALUES ('2b6f8df8f19bc855ede252f5539314689b1ba98add00baa9633c8e0b294af568980c4f2f95d65d51', '59dc5909044d72eff8a257c48b4c953801cbec641f2784b8a99c07ab295468bc12881bf0d5ddca53', 0, '2019-01-24 14:30:08');
INSERT INTO `oauth_refresh_tokens` VALUES ('36bc9a90323009cc42eff02540099ddfbd9b67cfbfddb0702f1561fcfb53a3e0f58b7cb7d7121155', 'a6fa420fb6089427b1db9e1de087bc58fc9e7152bfba2642af673ae26db34b7a9549a772caec8952', 0, '2019-01-24 14:34:34');
INSERT INTO `oauth_refresh_tokens` VALUES ('38cc263b61bb83ea57eda44cfe24bfc880df44c2e4de720af6d7b4436261a4e20b8122d51226aed2', 'd492faa1a7e299064c22ae97bfb17fa14b0828d9fa2111dfadf212ecc652bd53199ab99db6d56a4e', 0, '2019-01-17 14:20:32');
INSERT INTO `oauth_refresh_tokens` VALUES ('4100a6fa8bce1d80e53c6d102a9d4bed62f3ab415533dde003ce4949623ddde9d0653be69ee050a9', '55e9ce90ee713e1b7e6108088e27ead5a505b82fd54f063a72249fd374a1f851ccf3887a0cec9fb9', 0, '2019-10-03 06:31:23');
INSERT INTO `oauth_refresh_tokens` VALUES ('4a03ccabb4aefb49a5f210e0d026083c9e94a5c4249556da29cb5cd9bc12812134f752f66cd9e914', '8e629405924ace44ec4a1bedabaa5d8d2eb711a11b034449094f98a192123713bedeb208fa4c2d34', 0, '2019-10-04 08:10:20');
INSERT INTO `oauth_refresh_tokens` VALUES ('71d01e498f8d17cd9a0c2037ad8d3a8f7837c47a8a7524303fb495b45cc4e680e77e8edbe511825c', 'ebd02d4c0f3a172680210bfe10348d10b3798c4abd3c733b05dca6720a536de7f2481ccd16412792', 0, '2019-09-23 13:01:01');
INSERT INTO `oauth_refresh_tokens` VALUES ('77fa059885ad7cee9f043d733fc1dbda0ff7013584fed4cbc28bdb5ff462eb5442cae465a5f5dfd8', '5a1aa6f0ac5fa1c28de00b856d2068e71045e01b4bc320ef247c6e1a320ac279c449232ae7dfa487', 0, '2019-10-21 09:46:11');
INSERT INTO `oauth_refresh_tokens` VALUES ('84e5617606413ab4436f52236fb5d1a96ee9593ea46376a11fe0b9ce8db684d6acefdd9486784b3f', '35363771a695727c1b05b35f5e2734ad64771aebacf7fbd52c174575d4ecc36a097667d5dac4d3d7', 0, '2019-02-03 08:39:27');
INSERT INTO `oauth_refresh_tokens` VALUES ('8ca737982bdc5211c9b0bcf0a33ff9a677292cf677f96f368323e14847c286a9e20ef94f93d4a725', '96b8b455bf1541a568b2b7e84e41c7f166bd571b2aec5d4f966e54955f083160599159d3d61cedb5', 0, '2019-03-15 10:22:25');
INSERT INTO `oauth_refresh_tokens` VALUES ('9ea1e280e8d15cfa4cffe2b6792849948a3522b7a64a6b6f54143d61337c8a2f62227561c01093de', 'f032c7c07bc92a51952df5c824f8f5faa9b7ba753732b79d5b69416c670d0616e4d1d6d8fbca1c1d', 0, '2019-09-23 03:28:09');
INSERT INTO `oauth_refresh_tokens` VALUES ('c76dbb11183af0f913ec0dea11ff09a90ad7fbafcfe0f12e3895a6c19d46a1f0c41be3bc79aafd28', '9c7cf0682f76c7d4d4437774d2acf6cb75270667ad9c0f42fc5002a5470f1cb978037afad23b050c', 0, '2019-01-18 14:23:06');
INSERT INTO `oauth_refresh_tokens` VALUES ('eba31de2407336471d993cf54c1ee3f8ddb09b7c131820e53ace53672adb06f1270bbbdc2d968f45', '1ad212172a5a1099f48ab4606630077b4930e18261280f9d01609434497c14476ca1e311ce9acc89', 0, '2019-03-15 07:10:10');
INSERT INTO `oauth_refresh_tokens` VALUES ('ec9beef1f9daeee90140ca3c1a9d257af9298acc04190c96d8aa4219a83b44a4ab4cb744cc93bf14', '8cb154a7b77d16c74858e359e8a7b178df18c97826abfcf2a03658ea4b5b10ecbfd991ba64beaf10', 0, '2019-01-17 14:13:52');
INSERT INTO `oauth_refresh_tokens` VALUES ('f8c2f23646afda16d31e9d8d973b4d4475edba25f9a3e200baebce24f9889b6989dbabf446fb4ebc', 'a1538675035e0ba5b04b4bdbf78ebca1c3198e0680ea0a2a34fda963e05b8fb1269105b849417b44', 0, '2019-10-03 08:51:56');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `phone` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '手机号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_phone_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `users_phone_unique`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'tanren', '', '$2y$10$94MdtBtAkAjTDsVxvL83g.kwhCz2XY263aSbVxpsABgMFVUZ0H3Jm', NULL, '2019-01-08 14:26:58', '2019-01-08 14:26:58', '18373873100');
INSERT INTO `users` VALUES (2, 'fafawlp000001', '', '$2y$10$MlI4inolo63FnnJe9pdn4uFc/DXcc0gxpZSF5D2jYjGbU7YDGifGy', NULL, '2019-01-10 14:33:25', '2019-01-10 14:33:25', '13048901611');

SET FOREIGN_KEY_CHECKS = 1;
