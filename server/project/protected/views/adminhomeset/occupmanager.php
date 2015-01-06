<h2 class="contentTitle">英雄职业管理</h2>
<div id="resultBox"></div>
<?php
$type = array("剑士","法师","弓手","骑士");
foreach($models as $val){?>
<div style=" float:left; display:block; margin:10px; overflow:auto; width:240px; height:495px; overflow:auto; border:solid 1px #CCC; line-height:21px; background:#FFF;">
    <div style="text-align: center;">
    <a class="add" title="<?php echo $type[$val['type']]; ?>职业编辑" mask="true" height="560" width="600" target="dialog" href="<?php
        echo Yii::app()->createAbsoluteUrl('adminhomeset/occupedit',array("id"=>$val['id']));
    ?>">
    <img width="230" src="<?php echo Yii::app()->request->baseUrl.$val['img_url']; ?>"/></a>
    <?php
        for($i=1;$i<7;$i++)
        {
            if(!empty($val['jn'.$i.'_url']))
            {
                printf('<img width="46" height="46" src="%s%s" />',Yii::app()->request->baseUrl,$val['jn'.$i.'_url']);
            }
        }
    ?>
    </div>
</div>
<?php }?>