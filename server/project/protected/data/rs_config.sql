--
-- 表的结构 `rs_config`
--

CREATE TABLE IF NOT EXISTS `rs_config` (
  `name` varchar(64) NOT NULL COMMENT '配置项',
  `value` varchar(128) NOT NULL COMMENT '内容',
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常用配置项';

--
-- 转存表中的数据 `rs_config`
--

INSERT INTO `rs_config` (`name`, `value`) VALUES
('linevalue', '2');

CREATE TABLE IF NOT EXISTS `rs_config` (
  `name` varchar(64) NOT NULL COMMENT '配置项',
  `value` varchar(512) NOT NULL COMMENT '内容',
  PRIMARY KEY (`name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常用配置项';

--
-- 转存表中的数据 `rs_config`
--

INSERT INTO `rs_config` (`name`, `value`) VALUES
('android_download', ''),
('iosyy_download', ''),
('ios_download', ''),
('linevalue', '2144'),
('novice_package', ''),
('novice_strategy', ''),
('recharge_url', ''),
('txweibo_url', ''),
('video_url', ''),
('weibo_url', ''),
('wp_download', '');

INSERT INTO `rs_config` (`name`, `value`) VALUES
('title', ''),
('keywords', ''),
('description', '');