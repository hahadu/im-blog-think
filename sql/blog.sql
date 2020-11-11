-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-11-09 21:24:06
-- 服务器版本： 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP 版本： 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `du_address_mail`
--

CREATE TABLE `du_address_mail` (
  `id` int(15) NOT NULL,
  `uid` int(15) NOT NULL,
  `qq_group_id` int(200) DEFAULT NULL,
  `mail_name` varchar(30) NOT NULL COMMENT '收件人昵称',
  `qq_list` bigint(200) DEFAULT NULL,
  `mail_list` char(50) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `du_admin_nav`
--

CREATE TABLE `du_admin_nav` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '菜单表',
  `pid` int(11) UNSIGNED DEFAULT 0 COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `url` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `icon` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `order_by` int(11) UNSIGNED DEFAULT NULL COMMENT '排序',
  `delete_time` int(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_admin_nav`
--

INSERT INTO `du_admin_nav` (`id`, `pid`, `name`, `url`, `icon`, `order_by`, `delete_time`) VALUES
(1, 0, '权限控制', '/admin/nav_rule/rule', '', NULL, NULL),
(2, 1, '权限管理', '/admin/rule/index', '', NULL, NULL),
(3, 1, '用户组管理', '/admin/group/group', '', NULL, NULL),
(4, 1, '管理员列表', '/admin/rule_admin_user/admin_list', '', NULL, NULL),
(5, 0, '系统设置', '/admin/system/index', 'cogs', NULL, NULL),
(6, 5, '后台菜单管理', '/admin/admin_nav/index', '', NULL, NULL),
(7, 5, '状态码管理', '/admin/status_code/index', '', NULL, NULL),
(8, 0, '文章', '/admin/blog/index', 'tags', NULL, NULL),
(9, 8, '文章管理', '/admin/blog/index', '', NULL, NULL),
(10, 8, 'Tag管理', '/admin/tag/index', '', NULL, NULL),
(11, 10, '标签列表', '/admin/tag/index', '', NULL, NULL),
(12, 10, '添加标签', '/admin/tag/add', '', NULL, NULL),
(13, 8, '分类', '/admin/category/index', '', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_auth_group`
--

CREATE TABLE `du_auth_group` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` text DEFAULT NULL COMMENT '规则id',
  `delete_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组表';

--
-- 转存表中的数据 `du_auth_group`
--

INSERT INTO `du_auth_group` (`id`, `title`, `status`, `rules`, `delete_time`) VALUES
(1, '超级管理员', 1, '1,2,3,4,28,29,30,5,20,21,22,23,24,6,7,8,9,10,11,12,13,15,19,14,16,17,18,25,26,27,31,32,33,34,35,36,37,38,39,40,41,42,43,44', NULL),
(2, '文章管理', 1, '1,2,3,5', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_auth_group_access`
--

CREATE TABLE `du_auth_group_access` (
  `uid` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `group_id` int(11) UNSIGNED NOT NULL COMMENT '用户组id',
  `delete_time` int(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

--
-- 转存表中的数据 `du_auth_group_access`
--

INSERT INTO `du_auth_group_access` (`uid`, `group_id`, `delete_time`) VALUES
(1, 1, NULL),
(2, 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_auth_rule`
--

CREATE TABLE `du_auth_rule` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `pid` int(15) NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `condition` char(100) NOT NULL DEFAULT '',
  `delete_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_auth_rule`
--

INSERT INTO `du_auth_rule` (`id`, `pid`, `name`, `title`, `type`, `status`, `condition`, `delete_time`) VALUES
(1, 0, '/admin/index/index', '后台首页', 1, 1, '', NULL),
(2, 1, '/admin/index/welcome', '后台欢迎页', 1, 1, '', NULL),
(3, 0, '/admin/system/index', '系统设置', 1, 1, '', NULL),
(4, 3, '/admin/admin_nav/index', '后台菜单管理', 1, 1, '', NULL),
(5, 3, '/admin/status_code/index', '状态码管理', 1, 1, '', NULL),
(6, 0, '/admin/nav_rule/rule', '权限控制', 1, 1, '', NULL),
(7, 6, '/admin/rule/index', '权限管理', 1, 1, '', NULL),
(8, 7, '/admin/rule/add', '添加权限', 1, 1, '', NULL),
(9, 7, '/admin/rule/edit', '修改权限', 1, 1, '', NULL),
(10, 7, '/admin/rule/delete', '删除权限', 1, 1, '', NULL),
(11, 7, '/admin/rule/on_delete_rule', '已删除权限', 1, 1, '', NULL),
(12, 7, '/admin/rule/rec_delete_rule', '恢复已删除权限', 1, 1, '', NULL),
(13, 6, '/admin/rule_admin_user/admin_list', '管理员列表', 1, 1, '', NULL),
(14, 6, '/admin/group/group', '用户组管理', 1, 1, '', NULL),
(15, 13, '/admin/rule_admin_user/add_admin', '添加管理员', 1, 1, '', NULL),
(16, 14, '/admin/group/add_group', '添加用户组', 1, 1, '', NULL),
(17, 14, '/admin/group/edit_group', '修改用户组', 1, 1, '', NULL),
(18, 6, '/admin/rule_group/rule_group', '分配权限', 1, 1, '', NULL),
(19, 13, '/admin/rule_admin_user/edit_admin', '修改管理员', 1, 1, '', NULL),
(20, 5, '/admin/status_code/add', '添加状态码', 1, 1, '', NULL),
(21, 5, '/admin/status_code/edit', '修改状态码', 1, 1, '', NULL),
(22, 5, '/admin/status_code/delete', '删除状态码', 1, 1, '', NULL),
(23, 5, '/admin/status_code/on_delete', '已删除的状态码', 1, 1, '', NULL),
(24, 5, '/admin/status_code/rec_delete', '恢复已删除状态码', 1, 1, '', NULL),
(25, 18, '/admin/rule_group/add_user_from_group', '添加成员到组', 1, 1, '', NULL),
(26, 18, '/admin/rule_group/delete_user_from_group', '用户从组中删除', 1, 1, '', NULL),
(27, 18, '/admin/rule_group/check_user', '添加成员', 1, 1, '', NULL),
(28, 4, '/admin/admin_nav/add', '添加菜单', 1, 1, '', NULL),
(29, 4, '/admin/admin_nav/edit', '修改菜单', 1, 1, '', NULL),
(30, 4, '/admin/admin_nav/delete', '删除菜单', 1, 1, '', NULL),
(31, 0, '/admin/blog', '文章管理', 1, 1, '', NULL),
(32, 31, '/admin/blog/index', '文章', 1, 1, '', NULL),
(33, 32, '/admin/blog/add', '添加文章', 1, 1, '', NULL),
(34, 32, '/admin/blog/edit', '修改文章', 1, 1, '', NULL),
(35, 32, '/admin/blog/delete', '删除文件', 1, 1, '', NULL),
(36, 31, '/admin/tag/index', '标签', 1, 1, '', NULL),
(37, 36, '/admin/tag/add', '添加标签', 1, 1, '', NULL),
(38, 36, '/admin/tag/edit', '修改标签', 1, 1, '', NULL),
(39, 36, '/admin/tag/delete', '删除标签', 1, 1, '', NULL),
(40, 31, '/admin/category/index', '分类管理', 1, 1, '', NULL),
(41, 40, '/admin/category/add', '添加分类', 1, 1, '', NULL),
(42, 40, '/admin/category/edit', '修改分类', 1, 1, '', NULL),
(43, 40, '/admin/category/delete', '删除分类', 1, 1, '', NULL),
(44, 40, '/admin/category/order_by', '分类排序', 1, 1, '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_blog`
--

CREATE TABLE `du_blog` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '文章表主键',
  `title` char(100) NOT NULL DEFAULT '' COMMENT '标题',
  `author` varchar(15) NOT NULL DEFAULT '' COMMENT '作者 用户ID',
  `content` mediumtext NOT NULL COMMENT '文章内容',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` char(255) NOT NULL DEFAULT '' COMMENT '描述',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '文章是否显示 1是 0否',
  `is_top` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否置顶 1是 0否',
  `is_original` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否原创',
  `click` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点击数',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(64) UNSIGNED DEFAULT NULL COMMENT '是否删除 1是 0否',
  `cid` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_blog`
--

INSERT INTO `du_blog` (`id`, `title`, `author`, `content`, `keywords`, `description`, `is_show`, `is_top`, `is_original`, `click`, `create_time`, `update_time`, `delete_time`, `cid`) VALUES
(17, '测试文章标题', '1', '&lt;p&gt;测试文章内容&lt;/p&gt;', '关键词,多个', '测试文章描述', 1, 1, 1, 399, 1552649909, 1604850478, NULL, 28),
(18, '测试文章标题2', '1', '&lt;p&gt;&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC83NWM2N2Y4OTg5Y2JhM2I5ZDIyNGExMDY4NjU2YWJhNC5wbmdAaW1fYmxvZw==.png&quot; title=&quot;75c67f8989cba3b9d224a1068656aba4.png&quot; alt=&quot;images/20201108/75c67f8989cba3b9d224a1068656aba4.png&quot;/&gt;&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC9mNGE2YzFlMzkyNzRlOTJlMTZjZWZjZTA3NGNkMzZkMi5wbmdAaW1fYmxvZw==.png&quot; title=&quot;f4a6c1e39274e92e16cefce074cd36d2.png&quot; alt=&quot;images/20201108/f4a6c1e39274e92e16cefce074cd36d2.png&quot;/&gt;&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8zMjBhMzI2MDY4ZTY0ZjY1NThmZWRkYzViZDY1YTg0ZS5wbmdAaW1fYmxvZw==.png&quot; title=&quot;320a326068e64f6558feddc5bd65a84e.png&quot; alt=&quot;images/20201108/320a326068e64f6558feddc5bd65a84e.png&quot;/&gt;测试的文章内容&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC9lNmRlOWM3NDgwNGRjMTM1NDVjMjliNzg5NGEyNDUxNi5wbmdAaW1fYmxvZw==.png&quot; alt=&quot;images/20201108/e6de9c74804dc13545c29b7894a24516.png&quot;/&gt;&lt;video class=&quot;edui-upload-video  vjs-default-skin       video-js&quot; controls=&quot;&quot; preload=&quot;none&quot; width=&quot;420&quot; height=&quot;280&quot; src=&quot;/upload/videos/20201108/a99fc3f54799e8a209e42162bd1d5008.mp4&quot; data-setup=&quot;{}&quot;&gt;&lt;source src=&quot;/upload/videos/20201108/a99fc3f54799e8a209e42162bd1d5008.mp4&quot; type=&quot;video/mp4&quot;/&gt;&lt;/video&gt;&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8yNGRiZjdkNTlhMzI4ZDBmZGFiZDcyNzMzNDM1NTY1MS5wbmdAaW1fYmxvZw==.png&quot; alt=&quot;images/20201108/24dbf7d59a328d0fdabd727334355651.png&quot;/&gt;&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8xOTQwZTQ5M2ZkYmUxZDI1MDViNjQ1MzAyN2M2MTg4Ni5wbmdAaW1fYmxvZw==.png&quot; title=&quot;1940e493fdbe1d2505b6453027c61886.png&quot; alt=&quot;images/20201108/1940e493fdbe1d2505b6453027c61886.png&quot;/&gt;&lt;img style=&quot;vertical-align: middle; margin-right: 2px;&quot; src=&quot;http://192.168.1.113:8080/static/plugins/ueditor/dialogs/attachment/fileTypeImages/icon_jpg.gif&quot;/&gt;&lt;a style=&quot;font-size:12px; color:#0066cc;&quot; href=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ZpbGVzLzIwMjAxMTA4LzJmYTI0NjE1NTA1NDIxZGRlYWI4ZWE5YTQxNmUyY2Q5LnBuZ0BpbV9ibG9n.png&quot; title=&quot;files/20201108/2fa24615505421ddeab8ea9a416e2cd9.png&quot;&gt;files/20201108/2fa24615505421ddeab8ea9a416e2cd9.png&lt;/a&gt;&lt;/p&gt;', '关键词,多个,测试', '测试文章描述2', 1, 1, 1, 401, 1562649909, NULL, NULL, 28),
(23, '这是一个标题', '1', ' &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;哈哈很多都&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8xNWIxZmZjOGMwZjIxNDhjYjcwODhkZDQ4NzdlOWU3NC5wbmdAaW1fYmxvZw==.png&quot; alt=&quot;images/20201108/15b1ffc8c0f2148cb7088dd4877e9e74.png&quot;/&gt;&lt;p&gt;&lt;/p&gt;', '关键词1,关键词2,关键词3', '文章描述', 0, 1, 1, 1, 1604849629, 1604909894, NULL, 28),
(24, '这是一个标题', '1', ' &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;哈哈很多都&lt;img src=&quot;/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8xNWIxZmZjOGMwZjIxNDhjYjcwODhkZDQ4NzdlOWU3NC5wbmdAaW1fYmxvZw==.png&quot; alt=&quot;images/20201108/15b1ffc8c0f2148cb7088dd4877e9e74.png&quot;/&gt;s&lt;p&gt;&lt;/p&gt;', '关键词1,关键词2,关键词3', '文章描述', 1, 1, 1, 2, 1604849669, 1604909814, 1604909814, 28),
(25, '这是一个标题', '1', ' &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;sfasdfasas &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp; &amp;nbsp;', '关键词1,关键词2,关键词3', '文章描述', 1, 1, 1, 0, 1604849815, 1604909417, 1604909417, 28);

-- --------------------------------------------------------

--
-- 表的结构 `du_blog_pic`
--

CREATE TABLE `du_blog_pic` (
  `ap_id` int(10) UNSIGNED NOT NULL COMMENT '主键',
  `path` varchar(250) NOT NULL DEFAULT '' COMMENT '图片路径',
  `aid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属文章id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_blog_pic`
--

INSERT INTO `du_blog_pic` (`ap_id`, `path`, `aid`) VALUES
(54, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC83NWM2N2Y4OTg5Y2JhM2I5ZDIyNGExMDY4NjU2YWJhNC5wbmdAaW1fYmxvZw==.png', 18),
(55, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC9mNGE2YzFlMzkyNzRlOTJlMTZjZWZjZTA3NGNkMzZkMi5wbmdAaW1fYmxvZw==.png', 18),
(56, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8zMjBhMzI2MDY4ZTY0ZjY1NThmZWRkYzViZDY1YTg0ZS5wbmdAaW1fYmxvZw==.png', 18),
(57, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC9lNmRlOWM3NDgwNGRjMTM1NDVjMjliNzg5NGEyNDUxNi5wbmdAaW1fYmxvZw==.png', 18),
(58, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8yNGRiZjdkNTlhMzI4ZDBmZGFiZDcyNzMzNDM1NTY1MS5wbmdAaW1fYmxvZw==.png', 18),
(59, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8xOTQwZTQ5M2ZkYmUxZDI1MDViNjQ1MzAyN2M2MTg4Ni5wbmdAaW1fYmxvZw==.png', 18),
(60, 'http://192.168.1.113:8080/static/plugins/ueditor/dialogs/attachment/fileTypeImages/icon_jpg.gif', 18),
(61, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8xNWIxZmZjOGMwZjIxNDhjYjcwODhkZDQ4NzdlOWU3NC5wbmdAaW1fYmxvZw==.png', 23),
(63, '/upload/images/20201108/water/dGltZS4vdXBsb2FkL2ltYWdlcy8yMDIwMTEwOC8xNWIxZmZjOGMwZjIxNDhjYjcwODhkZDQ4NzdlOWU3NC5wbmdAaW1fYmxvZw==.png', 24);

-- --------------------------------------------------------

--
-- 表的结构 `du_blog_tag`
--

CREATE TABLE `du_blog_tag` (
  `aid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '文章id',
  `tid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '标签id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_blog_tag`
--

INSERT INTO `du_blog_tag` (`aid`, `tid`) VALUES
(18, 20),
(18, 37),
(17, 20),
(25, 20),
(25, 37);

-- --------------------------------------------------------

--
-- 表的结构 `du_category`
--

CREATE TABLE `du_category` (
  `cid` tinyint(2) UNSIGNED NOT NULL COMMENT '分类主键id',
  `cname` varchar(15) NOT NULL DEFAULT '' COMMENT '分类名称',
  `keywords` varchar(255) DEFAULT '' COMMENT '关键词',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `order_by` tinyint(2) UNSIGNED DEFAULT NULL COMMENT '排序',
  `pid` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级栏目id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_category`
--

INSERT INTO `du_category` (`cid`, `cname`, `keywords`, `description`, `order_by`, `pid`) VALUES
(28, '测试分类', '测试分类关键词', '测试分类描述', 1, 0),
(29, '测试子分类', '测试子分类关键词', '测试子分类描述', NULL, 28);

-- --------------------------------------------------------

--
-- 表的结构 `du_comment`
--

CREATE TABLE `du_comment` (
  `cmtid` int(10) UNSIGNED NOT NULL COMMENT '主键id',
  `ouid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论用户id 关联oauth_user表的id',
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1：文章评论',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id',
  `aid` int(10) UNSIGNED NOT NULL COMMENT '文章id',
  `content` text NOT NULL COMMENT '内容',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论日期',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '1:已审核 0：未审核',
  `delete_time` int(32) UNSIGNED DEFAULT NULL COMMENT '是否删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_comment`
--

INSERT INTO `du_comment` (`cmtid`, `ouid`, `type`, `pid`, `aid`, `content`, `create_time`, `status`, `delete_time`) VALUES
(19, 1, 1, 0, 17, '测试评论&lt;img src=&quot;/Public/emote/tuzki/t_0002.gif&quot; title=&quot;Love&quot; alt=&quot;hahadu博客&quot;&gt;', 1589747059, 1, NULL),
(21, 1, 1, 19, 17, '测试回复', 1597943018, 1, NULL),
(29, 1, 1, 21, 17, '测试子回复', 1602825658, 1, NULL),
(30, 1, 1, 0, 18, 'ttsdg', 1603725717, 1, NULL),
(31, 1, 1, 0, 17, '撒一波狗粮', 1603768011, 1, NULL),
(32, 1, 1, 0, 17, '撒一波狗粮', 1603768051, 1, NULL),
(33, 1, 1, 0, 17, '撒一波狗粮给你', 1603768171, 1, NULL),
(34, 1, 1, 0, 17, '撒一波狗粮给你', 1603768213, 1, NULL),
(35, 1, 1, 0, 17, '撒一波狗粮给你是', 1603768359, 1, NULL),
(36, 1, 1, 0, 17, '米有任何见解阔以发表', 1603768886, 1, NULL),
(37, 1, 1, 0, 17, '不做置评', 1603768950, 1, NULL),
(38, 1, 1, 0, 17, '不预制瓶阿发大婶方法', 1603769028, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_link`
--

CREATE TABLE `du_link` (
  `lid` int(10) UNSIGNED NOT NULL COMMENT '主键id',
  `lname` varchar(50) NOT NULL DEFAULT '' COMMENT '链接名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `sort` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '排序',
  `is_show` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '文章是否显示 1是 0否',
  `delete_time` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '是否删除 1是 0否'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_link`
--

INSERT INTO `du_link` (`lid`, `lname`, `url`, `sort`, `is_show`, `delete_time`) VALUES
(2, 'image', 'http://imagevd.com', 1, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_oauth_user`
--

CREATE TABLE `du_oauth_user` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '主键id',
  `uid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '关联的本站用户id',
  `type` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型 1：融云   2：友盟',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '第三方昵称',
  `head_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `openid` varchar(40) NOT NULL DEFAULT '' COMMENT '第三方用户id',
  `access_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'access_token token',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '绑定时间',
  `last_login_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '最后登录时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `du_order`
--

CREATE TABLE `du_order` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '订单主键',
  `order_sn` int(11) UNSIGNED NOT NULL COMMENT '订单号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `du_send_mail`
--

CREATE TABLE `du_send_mail` (
  `id` int(25) NOT NULL,
  `uid` int(50) DEFAULT NULL COMMENT '关联本站用户id',
  `usermail_id` int(50) DEFAULT NULL COMMENT '用户发信邮箱id',
  `send_address` text NOT NULL COMMENT '收件箱列表',
  `send_cont_id` int(15) DEFAULT NULL COMMENT '发信内容'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮件发送';

--
-- 转存表中的数据 `du_send_mail`
--

INSERT INTO `du_send_mail` (`id`, `uid`, `usermail_id`, `send_address`, `send_cont_id`) VALUES
(3, NULL, NULL, '237592008@qq.com', NULL),
(4, NULL, NULL, '3030728674@qq.com', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_send_msg_content`
--

CREATE TABLE `du_send_msg_content` (
  `id` int(15) NOT NULL,
  `uid` int(15) DEFAULT 0,
  `title` char(50) DEFAULT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态',
  `system` int(11) NOT NULL DEFAULT 0 COMMENT '是否系统模板',
  `create_time` int(11) DEFAULT NULL,
  `delete_time` int(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='发信内容';

--
-- 转存表中的数据 `du_send_msg_content`
--

INSERT INTO `du_send_msg_content` (`id`, `uid`, `title`, `content`, `status`, `system`, `create_time`, `delete_time`) VALUES
(1, 1, '你好', '\r\n 哈哈&#39;你好, <strong style=\"color:red\">朋友</strong>! <br/>这是一封来自<a href=\"com\" target=\"_blank\">www.dikudu.com</a>的邮件！<br/>&#39;.$data.&#39;<img alt=\"helloweba\" src=\"\'.$img.\'\"/>&#39; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;', 1, 1, 1511192514, NULL),
(2, 1, '感谢注册', ' <body style=\"font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;\" bgcolor=\"#E4E6E9\" leftmargin=\"0\" topmargin=\"0\" marginheight=\"0\" marginwidth=\"0\">\n <table width=\"100%\" height=\"100%\" bgcolor=\"#E4E6E9\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n <tr><td width=\"100%\" align=\"center\" valign=\"top\" bgcolor=\"#E4E6E9\" style=\"background-color:#E4E6E9; min-height: 200px;\">\n<table><tr><td class=\"table-td-wrap\" align=\"center\" width=\"458\"><table class=\"table-space\" height=\"18\" style=\"height: 18px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;\" width=\"450\" bgcolor=\"#E4E6E9\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"18\" style=\"height: 18px; width: 450px; background-color: #e4e6e9;\" width=\"450\" bgcolor=\"#E4E6E9\" align=\"left\">&nbsp;</td></tr></tbody></table>\n<table class=\"table-space\" height=\"8\" style=\"height: 8px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"8\" style=\"height: 8px; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" align=\"left\">&nbsp;</td></tr></tbody></table>\n\n<table class=\"table-row\" width=\"450\" bgcolor=\"#FFFFFF\" style=\"table-layout: fixed; background-color: #ffffff;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-row-td\" style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;\" valign=\"top\" align=\"left\">\n  <table class=\"table-col\" align=\"left\" width=\"378\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"table-layout: fixed;\"><tbody><tr><td class=\"table-col-td\" width=\"378\" style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;\" valign=\"top\" align=\"left\">\n    <table class=\"header-row\" width=\"378\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"table-layout: fixed;\"><tbody><tr><td class=\"header-row-td\" width=\"378\" style=\"font-family: Arial, sans-serif; font-weight: normal; line-height: 19px; color: #478fca; margin: 0px; font-size: 18px; padding-bottom: 10px; padding-top: 15px;\" valign=\"top\" align=\"left\">感谢您注册秀才社</td></tr></tbody></table>\n    <div style=\"font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;\">\n      <b style=\"color: #777777;\">您收到这封邮件是因为您在秀才社使用当前邮箱注册了账号</b>\n      <br>\n      如果不是您本人操作，请忽略本信息！\n      \n    </div>\n  </td></tr></tbody></table>\n</td></tr></tbody></table>\n    \n<table class=\"table-space\" height=\"12\" style=\"height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"12\" style=\"height: 12px; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" align=\"left\">&nbsp;</td></tr></tbody></table>\n<table class=\"table-space\" height=\"12\" style=\"height: 12px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"12\" style=\"height: 12px; width: 450px; padding-left: 16px; padding-right: 16px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" align=\"center\">&nbsp;<table bgcolor=\"#E8E8E8\" height=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td bgcolor=\"#E8E8E8\" height=\"1\" width=\"100%\" style=\"height: 1px; font-size:0;\" valign=\"top\" align=\"left\">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>\n<table class=\"table-space\" height=\"16\" style=\"height: 16px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"16\" style=\"height: 16px; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" align=\"left\">&nbsp;</td></tr></tbody></table>\n\n<table class=\"table-row\" width=\"450\" bgcolor=\"#FFFFFF\" style=\"table-layout: fixed; background-color: #ffffff;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-row-td\" style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;\" valign=\"top\" align=\"left\">\n  <table class=\"table-col\" align=\"left\" width=\"378\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"table-layout: fixed;\"><tbody><tr><td class=\"table-col-td\" width=\"378\" style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; width: 378px;\" valign=\"top\" align=\"left\">\n    <div style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; text-align: center;\">\n      <a href=\"http://www.xiucaishe.com\" style=\"color: #ffffff; text-decoration: none; margin: 0px; text-align: center; vertical-align: baseline; border: 4px solid #6fb3e0; padding: 4px 9px; font-size: 15px; line-height: 21px; background-color: #6fb3e0;\">&nbsp; 确定 &nbsp;</a>\n    </div>\n    <table class=\"table-space\" height=\"16\" style=\"height: 16px; font-size: 0px; line-height: 0; width: 378px; background-color: #ffffff;\" width=\"378\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"16\" style=\"height: 16px; width: 378px; background-color: #ffffff;\" width=\"378\" bgcolor=\"#FFFFFF\" align=\"left\">&nbsp;</td></tr></tbody></table>\n  </td></tr></tbody></table>\n</td></tr></tbody></table>\n\n<table class=\"table-space\" height=\"6\" style=\"height: 6px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"6\" style=\"height: 6px; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" align=\"left\">&nbsp;</td></tr></tbody></table>\n\n<table class=\"table-row-fixed\" width=\"450\" bgcolor=\"#FFFFFF\" style=\"table-layout: fixed; background-color: #ffffff;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-row-fixed-td\" style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 1px; padding-right: 1px;\" valign=\"top\" align=\"left\">\n  <table class=\"table-col\" align=\"left\" width=\"448\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"table-layout: fixed;\"><tbody><tr><td class=\"table-col-td\" width=\"448\" style=\"font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;\" valign=\"top\" align=\"left\">\n    <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"table-layout: fixed;\"><tbody><tr><td width=\"100%\" align=\"center\" bgcolor=\"#f5f5f5\" style=\"font-family: Arial, sans-serif; line-height: 24px; color: #bbbbbb; font-size: 13px; font-weight: normal; text-align: center; padding: 9px; border-width: 1px 0px 0px; border-style: solid; border-color: #e3e3e3; background-color: #f5f5f5;\" valign=\"top\">\n      <a href=\"#\" style=\"color: #428bca; text-decoration: none; background-color: transparent;\">XIUCAISHE.COM &copy; 2017</a>\n      <br>\n      <a href=\"#\" style=\"color: #478fca; text-decoration: none; background-color: transparent;\">qq</a>\n      .\n      <a href=\"#\" style=\"color: #5b7a91; text-decoration: none; background-color: transparent;\">微博</a>\n      .\n      <a href=\"#\" style=\"color: #dd5a43; text-decoration: none; background-color: transparent;\">唯一官网</a>\n    </td></tr></tbody></table>\n  </td></tr></tbody></table>\n</td></tr></tbody></table>\n<table class=\"table-space\" height=\"1\" style=\"height: 1px; font-size: 0px; line-height: 0; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"1\" style=\"height: 1px; width: 450px; background-color: #ffffff;\" width=\"450\" bgcolor=\"#FFFFFF\" align=\"left\">&nbsp;</td></tr></tbody></table>\n<table class=\"table-space\" height=\"36\" style=\"height: 36px; font-size: 0px; line-height: 0; width: 450px; background-color: #e4e6e9;\" width=\"450\" bgcolor=\"#E4E6E9\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody><tr><td class=\"table-space-td\" valign=\"middle\" height=\"36\" style=\"height: 36px; width: 450px; background-color: #e4e6e9;\" width=\"450\" bgcolor=\"#E4E6E9\" align=\"left\">&nbsp;</td></tr></tbody></table></td></tr></table>\n</td></tr>\n </table>\n</body>', 1, 1, 1511192514, NULL),
(3, 1, 'test001', '这是一封测试邮件', 0, 0, 1525969877, NULL),
(4, 1, '文章评论提醒', '站长你好：<br>\r\n&emsp;用户 %s 在 %s 评论了您的文章 <a href=\"%s\">%s</a> 内容如下:<br>\r\n%s  <br> 请尽快审核', 1, 1, 1561192514, NULL),
(5, 1, '评论回复提醒', '尊敬的%s你好：<br>\r\n&emsp; 用户 %s 在 %s 回复了您对 <a href=\"%s\">%s</a> 的评论  内容如下，快去看看吧:<br>\r\n     %s', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_send_user_mail`
--

CREATE TABLE `du_send_user_mail` (
  `id` int(30) NOT NULL,
  `uid` int(30) NOT NULL DEFAULT 0 COMMENT '关联本站用户',
  `smtp_address` char(50) DEFAULT NULL COMMENT 'SMTP服务器',
  `smtp_username` char(50) DEFAULT NULL COMMENT '发件地址',
  `smtp_password` char(50) DEFAULT NULL COMMENT '发件箱密码',
  `smtp_secure` varchar(15) NOT NULL DEFAULT 'ssl' COMMENT '链接方式，',
  `smtp_port` varchar(15) NOT NULL DEFAULT '465' COMMENT 'smtp端口号',
  `status` int(5) NOT NULL DEFAULT 0 COMMENT '用户状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户发件箱地址';

--
-- 转存表中的数据 `du_send_user_mail`
--

INSERT INTO `du_send_user_mail` (`id`, `uid`, `smtp_address`, `smtp_username`, `smtp_password`, `smtp_secure`, `smtp_port`, `status`) VALUES
(5, 88, 'smtp.qq.com', '', '', 'ssl', '465', 1);

-- --------------------------------------------------------

--
-- 表的结构 `du_status_code`
--

CREATE TABLE `du_status_code` (
  `id` int(11) NOT NULL,
  `code` int(32) NOT NULL COMMENT '页面查询状态码',
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '状态1:success,0:error',
  `message` varchar(50) NOT NULL COMMENT '页面状态说明',
  `title` varchar(200) DEFAULT ':(' COMMENT '页面h1内容',
  `response_code` int(10) DEFAULT 301 COMMENT '页面跳转码http_response_code',
  `wait_second` int(20) NOT NULL DEFAULT 3 COMMENT '跳转等待时间',
  `delete_time` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='状态码';

--
-- 转存表中的数据 `du_status_code`
--

INSERT INTO `du_status_code` (`id`, `code`, `status`, `message`, `title`, `response_code`, `wait_second`, `delete_time`) VALUES
(1, 100001, 1, '成功', ':)', 301, 1, NULL),
(2, 400001, 0, 'ERROR:失败', ':(', 301, 3, NULL),
(3, 400012, 0, '删除失败：子菜单包含数据，请先删除子菜单数据', ':(', 301, 3, NULL),
(4, 420001, 0, '提交失败', ':(', 301, 3, NULL),
(5, 420002, 0, '提交失败：数据错误', ':(', 301, 3, NULL),
(6, 1, 1, '成功', ':)', 301, 3, NULL),
(7, 0, 0, 'ERROR：失败', ':(', 301, 3, NULL),
(8, 100002, 1, '注册成功', ':)', 301, 3, NULL),
(9, 100011, 1, '修改成功', ':)', 301, 1, NULL),
(10, 100012, 1, '添加成功', ':)', 301, 1, NULL),
(11, 500011, 5, '警告：值不能为空', 'warning', 301, 3, NULL),
(12, 400011, 0, 'ERROR：删除失败!', ':(', 301, 3, NULL),
(13, 100013, 1, '删除成功', ':)', 301, 1, NULL),
(14, 404, 4, '页面不存在', '404', 404, 2, NULL),
(15, 100003, 1, '登录成功，请稍后...', ':)', 301, 3, NULL),
(16, 100021, 1, '数据恢复成功', ':)', 301, 2, NULL),
(17, 420221, 0, '数据恢复失败', ':(', 301, 3, NULL),
(18, 420011, 0, '修改失败.', ':(', 301, 3, NULL),
(19, 100004, 1, '注销登录成功，请稍后...', ':)', 301, 3, NULL),
(20, 420104, 0, '注销登录失败！', ':(', 301, 3, NULL),
(21, 300001, 0, '您没有权限访问', ':(', 301, 3, NULL),
(22, 420101, 0, '登录信息过期，请重新登录', ':(', 301, 3, NULL),
(23, 400013, 0, '删除失败：包含子权限，请先删除子权限', ':(', 301, 3, NULL),
(24, 420103, 0, '账号或密码错误', ':(', 301, 3, NULL),
(25, 420102, 0, '尚未登录，请登录后再试', ':(', 301, 3, NULL),
(26, 420105, 0, '验证码错误', ':(', 301, 2, NULL),
(27, 420301, 0, '添加失败，已经存在', ':(', 301, 2, NULL),
(28, 420003, 0, '失败：内容不能为空', ':(', 301, 2, NULL),
(29, 420106, 0, '验证码过期', ':(', 301, 2, NULL),
(30, 420107, 0, '邮箱验证失败', ':(', 301, 2, NULL),
(31, 420109, 0, '验证码必须', ':(', 301, 2, NULL),
(32, 420108, 0, '用户名必须', ':(', 301, 2, NULL),
(33, 420110, 0, '密码必须', ':(', 301, 2, NULL),
(34, 420111, 0, '重复密码错误', ':(', 301, 2, NULL),
(35, 420112, 0, '用户名已存在', ':(', 301, 2, NULL),
(36, 430001, 0, '分类不存在，请先添加分类', ':(', 302, 2, NULL),
(37, 430002, 0, '标签不存在，请先添加标签', ':(', 302, 2, NULL),
(38, 420113, 0, '用户不存在', ':(', 302, 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `du_tag`
--

CREATE TABLE `du_tag` (
  `tid` int(10) UNSIGNED NOT NULL COMMENT '标签主键',
  `tname` varchar(10) NOT NULL DEFAULT '' COMMENT '标签名'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_tag`
--

INSERT INTO `du_tag` (`tid`, `tname`) VALUES
(20, '测试标签'),
(37, 'll标签');

-- --------------------------------------------------------

--
-- 表的结构 `du_users`
--

CREATE TABLE `du_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；mb_password加密',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像，相对于upload/avatar目录',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `email_code` varchar(60) DEFAULT NULL COMMENT '激活码',
  `phone` bigint(11) UNSIGNED DEFAULT NULL COMMENT '手机号',
  `status` tinyint(1) NOT NULL DEFAULT 2 COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `register_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册时间',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) UNSIGNED DEFAULT NULL COMMENT '最后登录时间',
  `delete_time` int(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `du_users`
--

INSERT INTO `du_users` (`id`, `username`, `password`, `avatar`, `email`, `email_code`, `phone`, `status`, `register_time`, `last_login_ip`, `last_login_time`, `delete_time`) VALUES
(1, 'admin', '$2y$10$kt4rKC9Imln9IvvqmzCcEeSrCclV7D/95LdwgVqz6dTEibGN8wkgO', 'posts_widget_04.jpg', '582167246@qq.com', NULL, 1888888888, 1, 0, '192.168.1.1', 99999, NULL),
(2, 'test', '$2y$11$KAjRakM7tbEYUrSD5mWNMOqlksuBVwD8fuVFAq2ZtPqWwAjutYCLe', '', 'mmm', NULL, 15555555555, 1, 0, '', NULL, NULL),
(3, 'test2', '$2y$11$KAjRakM7tbEYUrSD5mWNMOqlksuBVwD8fuVFAq2ZtPqWwAjutYCLe', '', '582167246@qq.com', NULL, NULL, 2, 0, '', NULL, NULL),
(4, 'admin', '$2y$11$KAjRakM7tbEYUrSD5mWNMOqlksuBVwD8fuVFAq2ZtPqWwAjutYCLe', '', '582167246@qq.com', NULL, NULL, 2, 0, '', NULL, NULL),
(5, 'test3', '$2y$11$KAjRakM7tbEYUrSD5mWNMOqlksuBVwD8fuVFAq2ZtPqWwAjutYCLe', '', '582167246@qq.com', NULL, NULL, 2, 0, '', NULL, NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `du_address_mail`
--
ALTER TABLE `du_address_mail`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_admin_nav`
--
ALTER TABLE `du_admin_nav`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_auth_group`
--
ALTER TABLE `du_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_auth_group_access`
--
ALTER TABLE `du_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- 表的索引 `du_auth_rule`
--
ALTER TABLE `du_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- 表的索引 `du_blog`
--
ALTER TABLE `du_blog`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_blog_pic`
--
ALTER TABLE `du_blog_pic`
  ADD PRIMARY KEY (`ap_id`);

--
-- 表的索引 `du_category`
--
ALTER TABLE `du_category`
  ADD PRIMARY KEY (`cid`);

--
-- 表的索引 `du_comment`
--
ALTER TABLE `du_comment`
  ADD PRIMARY KEY (`cmtid`);

--
-- 表的索引 `du_link`
--
ALTER TABLE `du_link`
  ADD PRIMARY KEY (`lid`);

--
-- 表的索引 `du_oauth_user`
--
ALTER TABLE `du_oauth_user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_order`
--
ALTER TABLE `du_order`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_send_mail`
--
ALTER TABLE `du_send_mail`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_send_msg_content`
--
ALTER TABLE `du_send_msg_content`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_send_user_mail`
--
ALTER TABLE `du_send_user_mail`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_status_code`
--
ALTER TABLE `du_status_code`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `du_tag`
--
ALTER TABLE `du_tag`
  ADD PRIMARY KEY (`tid`);

--
-- 表的索引 `du_users`
--
ALTER TABLE `du_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_login_key` (`username`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `du_address_mail`
--
ALTER TABLE `du_address_mail`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123800;

--
-- 使用表AUTO_INCREMENT `du_admin_nav`
--
ALTER TABLE `du_admin_nav`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单表', AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `du_auth_group`
--
ALTER TABLE `du_auth_group`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `du_auth_rule`
--
ALTER TABLE `du_auth_rule`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- 使用表AUTO_INCREMENT `du_blog`
--
ALTER TABLE `du_blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章表主键', AUTO_INCREMENT=26;

--
-- 使用表AUTO_INCREMENT `du_blog_pic`
--
ALTER TABLE `du_blog_pic`
  MODIFY `ap_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键', AUTO_INCREMENT=64;

--
-- 使用表AUTO_INCREMENT `du_category`
--
ALTER TABLE `du_category`
  MODIFY `cid` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类主键id', AUTO_INCREMENT=32;

--
-- 使用表AUTO_INCREMENT `du_comment`
--
ALTER TABLE `du_comment`
  MODIFY `cmtid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `du_link`
--
ALTER TABLE `du_link`
  MODIFY `lid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id', AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `du_oauth_user`
--
ALTER TABLE `du_oauth_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id';

--
-- 使用表AUTO_INCREMENT `du_order`
--
ALTER TABLE `du_order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单主键';

--
-- 使用表AUTO_INCREMENT `du_send_mail`
--
ALTER TABLE `du_send_mail`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `du_send_msg_content`
--
ALTER TABLE `du_send_msg_content`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `du_send_user_mail`
--
ALTER TABLE `du_send_user_mail`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `du_status_code`
--
ALTER TABLE `du_status_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- 使用表AUTO_INCREMENT `du_tag`
--
ALTER TABLE `du_tag`
  MODIFY `tid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '标签主键', AUTO_INCREMENT=38;

--
-- 使用表AUTO_INCREMENT `du_users`
--
ALTER TABLE `du_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
