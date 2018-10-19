/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.23-0ubuntu0.16.04.1 : Database - wanghuatong
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wanghuatong` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `wanghuatong`;

/*Table structure for table `admin_menu` */

DROP TABLE IF EXISTS `admin_menu`;

CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_operation_log` */

DROP TABLE IF EXISTS `admin_operation_log`;

CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `input` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1355 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_permissions` */

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_role_menu` */

DROP TABLE IF EXISTS `admin_role_menu`;

CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_role_permissions` */

DROP TABLE IF EXISTS `admin_role_permissions`;

CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_role_users` */

DROP TABLE IF EXISTS `admin_role_users`;

CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_user_permissions` */

DROP TABLE IF EXISTS `admin_user_permissions`;

CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `wht_book` */

DROP TABLE IF EXISTS `wht_book`;

CREATE TABLE `wht_book` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '书籍名称',
  `book_auther` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '书籍作者',
  `book_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '书籍图片',
  `book_desc` text COLLATE utf8_unicode_ci COMMENT '书籍介绍',
  `book_type` int(11) NOT NULL DEFAULT '99' COMMENT '书籍类型 99其他',
  `view_num` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `click_num` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `follow_num` int(11) NOT NULL DEFAULT '0' COMMENT '关注量',
  `sort` int(11) NOT NULL DEFAULT '9999' COMMENT '升序排列',
  `word_num` bigint(32) NOT NULL DEFAULT '0' COMMENT '书籍字数',
  `key_word` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '书籍关键字',
  `auther_uid` bigint(32) NOT NULL DEFAULT '0' COMMENT '书籍作者userid',
  `is_update` tinyint(1) NOT NULL DEFAULT '0' COMMENT '更新状态0未更新1已更新',
  `is_over` tinyint(1) NOT NULL DEFAULT '0' COMMENT '连载状态0连载中1已完结2断更',
  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '付费状态0不付费1付费2部分付费',
  `nav_recommend` tinyint(10) NOT NULL DEFAULT '0' COMMENT '首页推荐0未推荐1推荐',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示0不显示',
  `new_chapter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最新章节名称',
  `chapter_id` bigint(32) DEFAULT '0' COMMENT '最新章节id',
  `update_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=363 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='书籍信息表';

/*Table structure for table `wht_book_chapter` */

DROP TABLE IF EXISTS `wht_book_chapter`;

CREATE TABLE `wht_book_chapter` (
  `chapter_id` bigint(32) NOT NULL COMMENT '章节id',
  `book_id` bigint(32) NOT NULL COMMENT '书籍ID',
  `chapter_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '章节名称',
  `content_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容路径',
  `is_pay` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0不付费1付费',
  `pay_money` int(11) NOT NULL DEFAULT '0' COMMENT '付费金额以分为单位',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示0不显示',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '下载成功1未成功0',
  `spider_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '下载url',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='书籍章节表';

/*Table structure for table `wht_spider_hash_log` */

DROP TABLE IF EXISTS `wht_spider_hash_log`;

CREATE TABLE `wht_spider_hash_log` (
  `spider_url_hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'url hash 唯一',
  `spider_chapter_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '章节url'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='爬虫去重表';

/*Table structure for table `wht_spider_log` */

DROP TABLE IF EXISTS `wht_spider_log`;

CREATE TABLE `wht_spider_log` (
  `id` bigint(32) NOT NULL AUTO_INCREMENT,
  `spider_id` int(11) NOT NULL COMMENT '爬虫id',
  `book_id` bigint(32) NOT NULL DEFAULT '0' COMMENT '爬取书籍',
  `book_type` int(11) NOT NULL COMMENT '书籍类型',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '爬取类型1书籍类型0书籍',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否爬取成功1成功0未成功',
  `spider_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '爬取URL',
  `spider_url_hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'url hash 唯一',
  `spider_chapter_id` bigint(32) NOT NULL DEFAULT '0' COMMENT '爬取最新章节',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci COMMENT '采集错误信息',
  PRIMARY KEY (`id`),
  UNIQUE KEY `spider_url_hash` (`spider_url_hash`)
) ENGINE=MyISAM AUTO_INCREMENT=361 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='爬虫书籍记录表';

/*Table structure for table `wht_spider_setting` */

DROP TABLE IF EXISTS `wht_spider_setting`;

CREATE TABLE `wht_spider_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spider_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '爬虫名称',
  `spider_key_word` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '爬虫关键字',
  `page_start` int(11) NOT NULL DEFAULT '0' COMMENT '爬取开始页码',
  `page_end` int(11) NOT NULL DEFAULT '0' COMMENT '爬取结束页码',
  `book_type` int(11) NOT NULL COMMENT '爬取类型',
  `finsh_page` int(11) NOT NULL DEFAULT '0' COMMENT '已完成页码',
  `spider_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '爬取url',
  `spider_config` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '配置文件',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='爬虫配置';

/*Table structure for table `wht_type` */

DROP TABLE IF EXISTS `wht_type`;

CREATE TABLE `wht_type` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型名称',
  `type_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型介绍',
  `state` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0使用1停用',
  `sort` int(11) NOT NULL DEFAULT '99999' COMMENT '升序排列',
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='书籍类型表';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
