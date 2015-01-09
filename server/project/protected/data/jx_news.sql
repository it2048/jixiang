
CREATE TABLE IF NOT EXISTS `jx_news` (
  `id` int(11) NOT NULL COMMENT '自增编号',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `adduser` varchar(32) NOT NULL COMMENT '添加用户',
  `title` varchar(128) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `img_url` varchar(128) NOT NULL COMMENT '图片地址',
  `type` int(11) NOT NULL COMMENT '新闻类型',
  `child_list` varchar(128) DEFAULT NULL COMMENT '关联文章',
  `comment` int(11) DEFAULT NULL COMMENT '评论数',
  `like` int(11) DEFAULT NULL COMMENT '喜欢数',
  `han` int(11) DEFAULT NULL COMMENT '汗数',
  `hate` int(11) DEFAULT NULL COMMENT '厌恶数',
  `source` varchar(128) DEFAULT NULL COMMENT '来源',
  `status` int(11) DEFAULT NULL COMMENT '0表示普通，1为置顶(广告)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='新闻列表';