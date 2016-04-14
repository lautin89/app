/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : sh38

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-03-25 08:53:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `think_admin_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `think_admin_auth_group`;
CREATE TABLE `think_admin_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_admin_auth_group
-- ----------------------------
INSERT INTO `think_admin_auth_group` VALUES ('1', '管理员', '1', '2,3,4,5,6,7,8,9,10,1,12,13,11,14,15,16,17,18,19,20,21');
INSERT INTO `think_admin_auth_group` VALUES ('8', '超级用户', '1', ',7,14,1');
INSERT INTO `think_admin_auth_group` VALUES ('9', '普通用户', '1', ',1');

-- ----------------------------
-- Table structure for `think_admin_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `think_admin_auth_group_access`;
CREATE TABLE `think_admin_auth_group_access` (
  `uid` mediumint(11) unsigned NOT NULL,
  `group_id` mediumint(11) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of think_admin_auth_group_access
-- ----------------------------
INSERT INTO `think_admin_auth_group_access` VALUES ('3', '1');
INSERT INTO `think_admin_auth_group_access` VALUES ('6', '1');
INSERT INTO `think_admin_auth_group_access` VALUES ('7', '9');
INSERT INTO `think_admin_auth_group_access` VALUES ('8', '9');
INSERT INTO `think_admin_auth_group_access` VALUES ('9', '8');

-- ----------------------------
-- Table structure for `think_admin_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `think_admin_auth_rule`;
CREATE TABLE `think_admin_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_admin_auth_rule
-- ----------------------------
INSERT INTO `think_admin_auth_rule` VALUES ('1', 'User/index', '查看用户', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('2', 'User/add', '添加用户', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('3', 'User/insert', '插入用户', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('4', 'User/edit', '编辑用户', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('5', 'User/update', '修改用户', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('6', 'User/delete', '删除用户', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('7', 'Role/index', '查看分组角色', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('20', 'Role/setAuthGroup', '修改分组权限', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('9', 'Role/editTitle', '编辑分组角色显示名', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('10', 'Role/updateTitle', '修改分组角色显示名', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('11', 'Role/add', '添加角色分组', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('12', 'Role/insert', '插入角色分组', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('13', 'Role/delete', '删除角色分组', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('14', 'Auth/index', '查看权限', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('15', 'Auth/add', '添加权限', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('16', 'Auth/insert', '插入权限', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('17', 'Auth/edit', '编辑权限', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('18', 'Auth/update', '修改权限', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('19', 'Auth/opts', '权限操作', '1', '1', '');
INSERT INTO `think_admin_auth_rule` VALUES ('21', 'User/setAuthGroupAccess', '设置用户角色', '1', '1', '');

-- ----------------------------
-- Table structure for `think_admin_column`
-- ----------------------------
DROP TABLE IF EXISTS `think_admin_column`;
CREATE TABLE `think_admin_column` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of think_admin_column
-- ----------------------------
INSERT INTO `think_admin_column` VALUES ('1', '栏目管理', '0', '0', 'Column');
INSERT INTO `think_admin_column` VALUES ('2', '所有栏目', '1', '0,1', 'Column/index');
INSERT INTO `think_admin_column` VALUES ('3', '添加栏目', '1', '0,1', 'Column/add');
INSERT INTO `think_admin_column` VALUES ('4', '用户管理', '0', '0', 'User');
INSERT INTO `think_admin_column` VALUES ('5', '用户列表', '4', '0,4', 'User/index');
INSERT INTO `think_admin_column` VALUES ('6', '添加用户', '4', '0,4', 'User/add');
INSERT INTO `think_admin_column` VALUES ('7', '角色管理', '0', '0', 'Role');
INSERT INTO `think_admin_column` VALUES ('8', '角色列表', '7', '0,7', 'Role/index');
INSERT INTO `think_admin_column` VALUES ('9', '添加角色', '7', '0,7', 'Role/add');
INSERT INTO `think_admin_column` VALUES ('10', '权限管理', '0', '0', 'Auth');
INSERT INTO `think_admin_column` VALUES ('11', '权限列表', '10', '0,10', 'Auth/index');
INSERT INTO `think_admin_column` VALUES ('12', '添加权限', '10', '0,10', 'Auth/add');
INSERT INTO `think_admin_column` VALUES ('49', '使用说明', '1', '0,1', 'Column/about');

-- ----------------------------
-- Table structure for `think_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_admin_user`;
CREATE TABLE `think_admin_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(30) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `logined` datetime DEFAULT NULL,
  `createtime` datetime NOT NULL ,
  `times` int(5) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_admin_user
-- ----------------------------
INSERT INTO `think_admin_user` VALUES ('3', 'admin', '安德明', 'e10adc3949ba59abbe56e057f20f883e', '2016-03-24 20:30:35', '2016-03-24 20:42:51', '33');
INSERT INTO `think_admin_user` VALUES ('7', 'zhangsan', '张三', 'e10adc3949ba59abbe56e057f20f883e', '2016-03-22 17:02:51', '2016-03-24 20:34:58', '4');