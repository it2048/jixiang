<!DOCTYPE html>
<html>
<head>
    <?php $home = Yii::app()->request->baseUrl."/public/home/";?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo empty($this->models['title'])?"":$this->models['title']; ?></title>
    <meta name="keywords" content="<?php echo empty($this->models['keywords'])?"":$this->models['keywords']; ?>"/>
    <meta name="description" content="<?php echo empty($this->models['description'])?"":$this->models['description']; ?>"/>
    <link href="<?php echo $home; ?>css/style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body class="<?php
if(in_array($this->getAction()->getId(),array("news","article","articletmp")))
    echo "news_bg";
if(in_array($this->getAction()->getId(),array("info","resource","hero","herotmp","occupation")))
    echo "hero_bg";
?>">
<div class="head">
    <div class="wrap head_pori">
        <a href=""><img src="<?php echo $home; ?>images/logo.png" title="燃烧的英雄" alt="燃烧的英雄" class="logo"></a>
        <div class="nav clearfix">
            <a href="" class="fr">论坛</a>
            <a href="" class="fr">账号</a>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('home/info'); ?>" class="fr <?php echo in_array($this->tag,array("info",""))?"cur":"";?>">资料</a>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('home/'); ?>" class="fl <?php echo $this->tag=="index"?"cur":"";?>">首页</a>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('home/news'); ?>" class="fl <?php echo in_array($this->tag,array("news","article"))?"cur":"";?>">新闻</a>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('home/hero'); ?>" class="fl <?php echo in_array($this->tag,array("hero","occupation"))?"cur":"";?>">英雄</a>
        </div>
    </div>
</div>
	<?php echo $content; ?>
<div class="footer">
    <img src="<?php echo $home; ?>images/footer_logo.png" alt="" class="footer_logo" />
    <p>抵制不良游戏 拒绝盗版游戏   注意自我保护 谨防受骗上当   适当游戏益脑 沉迷游戏伤身   合理安排时间 享受健康生活</p>
    <p><a href="http://www.windplay.cn/js/2014/0521/4.html">关于公司</a> | <a href="http://www.windplay.cn/zc/">实名注册</a> | <a href="http://www.windplay.cn/jzjh/" target="_blank">家长监护</a> | <a href="http://www.windplay.cn/sw/">商务合作</a> | <a href="http://www.windplay.cn/rczp/scb/">人才招聘</a></p>
    <p>成都风际网络科技有限公司 版权所有 蜀ICP备13020373号</p>
    <p><a href="http://www.gov.cn/flfg/2011-03/21/content_1828568.htm" target="_blank">《互联网文化暂行规定》  </a><a href="mailto:wlyxjb@gmail.com" target="_blank">文化部网络游戏举报与联系邮箱：wlyxjb@gmail.com  </a><a href="http://www.scjb.gov.cn/" target="_blank">四川省互联网不良与违法信息举报中心</a></p>
</div>
<script type="text/javascript" src="<?php echo $home; ?>js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>js/min.index.js"></script>
</body>
</html>