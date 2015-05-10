/*
Navicat MySQL Data Transfer

Source Server         : 本地localhost
Source Server Version : 50510
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50510
File Encoding         : 65001

Date: 2011-07-24 13:54:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_innodb`
-- ----------------------------
DROP TABLE IF EXISTS `t_innodb`;
CREATE TABLE `t_innodb` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `name` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_innodb
-- ----------------------------
INSERT INTO `t_innodb` VALUES ('178', 'wo#wangxian.me', 'wx', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `t_notebook`
-- ----------------------------
DROP TABLE IF EXISTS `t_notebook`;
CREATE TABLE `t_notebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_notebook
-- ----------------------------
INSERT INTO `t_notebook` VALUES ('6', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:08');
INSERT INTO `t_notebook` VALUES ('7', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:08');
INSERT INTO `t_notebook` VALUES ('8', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:08');
INSERT INTO `t_notebook` VALUES ('9', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:14');
INSERT INTO `t_notebook` VALUES ('10', '内容列表写记事 查看记事 ', '123', '2010-12-10 10:53:53', '2011-01-14 00:30:08');
INSERT INTO `t_notebook` VALUES ('11', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:14');
INSERT INTO `t_notebook` VALUES ('12', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:14');
INSERT INTO `t_notebook` VALUES ('13', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:19');
INSERT INTO `t_notebook` VALUES ('14', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:20');
INSERT INTO `t_notebook` VALUES ('15', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:20');
INSERT INTO `t_notebook` VALUES ('16', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:20');
INSERT INTO `t_notebook` VALUES ('17', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('18', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('19', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('20', '完成剩下的示例开发，截止到现在，示例全部完成。', '完成剩下的示例开发，截止到现在，示例全部完成。', '2010-12-09 10:53:37', '2010-12-09 11:16:47');
INSERT INTO `t_notebook` VALUES ('21', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('22', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('23', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('25', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('26', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('27', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('28', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('29', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('30', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('31', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('32', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:33');
INSERT INTO `t_notebook` VALUES ('33', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('34', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('35', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('36', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('37', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('38', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('39', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('40', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('41', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('42', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('45', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('46', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('47', '2222222', '123', '2010-12-09 10:53:32', '2010-12-09 13:24:41');
INSERT INTO `t_notebook` VALUES ('48', '我的内容来了', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 10:54:36');
INSERT INTO `t_notebook` VALUES ('49', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:43');
INSERT INTO `t_notebook` VALUES ('50', '内容列表', '123', '2010-12-10 10:53:53', '2010-12-09 10:54:43');
INSERT INTO `t_notebook` VALUES ('51', '内容列表', '123', '2010-12-09 10:53:32', '2010-12-09 10:54:43');
INSERT INTO `t_notebook` VALUES ('52', '111111111', '我的内容案例！', '2010-12-09 10:53:37', '2010-12-09 13:24:30');
INSERT INTO `t_notebook` VALUES ('53', '我的记事本', '我的内容案例！', '2010-12-09 10:51:40', '2011-01-19 11:31:44');
INSERT INTO `t_notebook` VALUES ('58', '内容列表', '123qqqqq', '2010-12-10 10:53:53', '2011-01-14 00:29:39');
INSERT INTO `t_notebook` VALUES ('59', '有一个得意的门神', '123', '2010-12-09 10:53:32', '2011-01-19 11:31:32');
INSERT INTO `t_notebook` VALUES ('60', '单位标题', '我的内容案例！', '2010-12-09 10:53:37', '2011-01-19 11:31:56');
INSERT INTO `t_notebook` VALUES ('61', '我的内容来了', '我的内容案例！', '2010-12-09 10:51:40', '2010-12-09 10:54:43');
INSERT INTO `t_notebook` VALUES ('66', 'Note that the ', 'Note that the NetFlow and sFlow plugins - if enabled - force -M to be set (i.e. they disable interface merging).', '2010-12-09 11:59:02', '2010-12-09 12:11:36');
INSERT INTO `t_notebook` VALUES ('64', 'Copyright ©2010 Powered by ePHP', '我的内容案例！\r\na\r\na\r\na\r\na\r\na\r\na\r\n', '2010-12-09 10:53:37', '2011-01-19 11:31:13');
INSERT INTO `t_notebook` VALUES ('68', '========== ePHP更新记录 =============', '更新记录\r\n2010-12-08\r\n完成剩下的示例开发，截止到现在，示例全部完成。\r\n下一步开发一个综合示例。99.multiple 的综合示例。\r\n2010-12-07\r\n美化了示例文档，添加css样式。\r\n完成了模型操作的链式操作方法的说明6.models。\r\n完成用原生sql语句操作数据的说明7.db\r\n完成示例xml、http、link、session、verifycode，主要是第三方应用。\r\n2010-12-3\r\n整理所有的示例目录examples，删除多余的目录和文件。\r\n删掉目录下的.htaccess文件，不是每一个目录都需要的。\r\n完成5、views示例。\r\n2010-12-2\r\n从今天开始起，开始写文档了。\r\n添加了4个开发实例，HelloWorld?、runinfo、error_test、cache\r\n', '2010-12-09 12:13:16', '2010-12-09 12:15:06');

-- ----------------------------
-- Table structure for `t_test`
-- ----------------------------
DROP TABLE IF EXISTS `t_test`;
CREATE TABLE `t_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(22) CHARACTER SET utf8 NOT NULL,
  `adate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ttrr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_test
-- ----------------------------
INSERT INTO `t_test` VALUES ('1', '木頭', '2011-02-07 22:32:47', '');
INSERT INTO `t_test` VALUES ('2', '大人', '2011-02-07 22:32:58', '');
INSERT INTO `t_test` VALUES ('3', '小孩张', '2011-02-07 22:33:04', '');
INSERT INTO `t_test` VALUES ('12', '大人', '2011-07-23 17:45:37', '');
INSERT INTO `t_test` VALUES ('13', 'WangXian', '2011-03-13 11:25:32', '');
INSERT INTO `t_test` VALUES ('14', 'WangXian', '2011-03-13 11:25:32', '');
INSERT INTO `t_test` VALUES ('15', 'WangXian', '2011-03-13 11:28:09', '');
INSERT INTO `t_test` VALUES ('16', 'WangXian', '2011-03-13 11:45:05', '');
INSERT INTO `t_test` VALUES ('17', 'WangXian', '2011-07-23 17:44:07', '');
INSERT INTO `t_test` VALUES ('18', 'WangXian', '2011-07-23 17:44:10', '');
INSERT INTO `t_test` VALUES ('19', 'WangXian', '2011-07-23 17:44:18', '');
INSERT INTO `t_test` VALUES ('20', '889', '2011-07-23 17:46:57', '');
INSERT INTO `t_test` VALUES ('21', '889', '2011-07-23 17:46:49', '');
INSERT INTO `t_test` VALUES ('22', '250', '2011-07-23 17:46:45', '');
INSERT INTO `t_test` VALUES ('23', '180', '2011-07-23 17:46:41', '');
INSERT INTO `t_test` VALUES ('24', 'obli', '2011-07-23 17:46:36', '');
INSERT INTO `t_test` VALUES ('25', 'xio', '2011-07-23 17:46:28', '');
INSERT INTO `t_test` VALUES ('26', 'dapang', '2011-07-23 17:46:21', '');
INSERT INTO `t_test` VALUES ('27', 'siji', '2011-07-23 17:46:16', '');
INSERT INTO `t_test` VALUES ('28', 'test', '2011-07-23 17:58:28', '');
INSERT INTO `t_test` VALUES ('29', 'test', '2011-07-23 17:58:30', '');
INSERT INTO `t_test` VALUES ('30', 'wx', '2011-07-23 23:41:06', '');
