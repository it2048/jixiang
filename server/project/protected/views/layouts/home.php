<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $home = Yii::app()->request->baseUrl."/public/home/";?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>每日新闻</title>
<link rel="stylesheet" href="<?php echo $home; ?>css/cssreset.css">
<script src="<?php echo $home; ?>js/jquery.min.js"></script>
<script src="<?php echo $home; ?>js/jquery.mobile.min.js"></script>
<style type="text/css">
.ui-content {
	border-width: 0;
	overflow: visible;
	overflow-x: hidden;
	padding: 0;
	background-color:#ffffff;
}
.ui-panel-inner {
	padding: 0;
	background-color:#ffffff;
}
body {
	width: 100%;
	min-width: 240px;
}
html,body{
	background:#fff;
}
#header {
	background: #000000 repeat-x;
	height: 43px;
	line-height: 43px;
	text-align: center;
}
#header b{
	color: #ffffff;
	font-size: 14px;
	font-weight: normal;
	text-shadow: none;
}
#info_content {
	padding: 15px;
}
#title {
	text-align: left;
	font-size: 20px;
	color: #3e3a39;
	padding: 0 0 4px 0;
}
#time {
	text-align: left;
	font-size: 11px;
	color: #b4b4b5;
	padding: 0 10px 4px 0;
}
#msg_content {
	padding: 10px 0;
	font-size: 15px;
	color: #3e3a39;
}
#msg_content img{
	width:100%;
}
#float_layer {
	z-index : 999;
	width:100%;
	position:fixed; 
	height: 60px;
	line-height: 60px;
	bottom:0;
	right:0;
	background-color:#191919;
	filter:alpha(opacity=90); 
	-moz-opacity:0.9; 
	opacity:0.9;
}
#icon{
	float:left;
	margin:10px 0 0 18px;
}
#btn_open{
	float:right;
	margin:14px 18px 0 0;
}
</style>
<script type="text/javascript">
	
	$().ready(function () {
		
	});  
	 
</script>
</head>
<body>
<div bgcolor="#ffffff">
    <?php echo $content; ?>
 <div id="float_layer" ><img id="icon" src="<?php echo $home; ?>img/icon.png" /><img id="btn_open" src="<?php echo $home; ?>img/btn_open.png" /></div>
</div>

</body>
</html>
