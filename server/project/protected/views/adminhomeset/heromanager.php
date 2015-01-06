<form onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/heromanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" mask="true" height="560" width="600" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/heroadd');?>"><span>添加英雄</span></a></li>
            <li><a class="icon" target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl('home/herotmp');?>"><span>预览</span></a></li>
        </ul>
    </div>
    <table class="list" width="960" layoutH="56">
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tbody>

        <tr align="center">
            <?php
            $i = 0;
            foreach ($models as $val) {

                $tmpstr = sprintf('<td><img src="%s" width="150" height="220" /><br/>
                    <a target="ajaxTodo" title="确定要删除吗?" href="%s" callback="deleteAuCall">删除</a>|
                    <a href="%s" mask="true" height="560" width="600" target="dialog">编辑</a>|
                    <a href="%s" target="ajaxTodo" title="确定要%s吗?" callback="deleteAuCall">%s</a>
                </td>',Yii::app()->request->baseUrl.$val['img_url'],Yii::app()->createAbsoluteUrl('adminhomeset/herodel',array('id'=>$val['id'])),
                    Yii::app()->createAbsoluteUrl('adminhomeset/heroedit',array('id'=>$val['id'])),
                    Yii::app()->createAbsoluteUrl('adminhomeset/heropublish',array('id'=>$val['id'])),$val['publish']==1?"取消发布":"发布",
                        $val['publish']==1?"<span style='color:red;margin-top:3px;'>取消发布</span>":"发布");
                if($i%4==0&&$i!=0)
                {
                    echo '</tr><tr align="center">'.$tmpstr;
                }
                else
                {
                    echo $tmpstr;
                }
                $i++;
            }
            ?>
        </tr>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <span>共<?php echo $pages['countPage'];?>条</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $pages['countPage'];?>" numPerPage="30" pageNumShown="10" currentPage="<?php echo $pages['pageNum'];?>"></div>
    </div>
</div>
<script type="text/javascript">
    function deleteAuCall(res)
    {
        if(res.code!=0)
            alertMsg.error(res.msg);
        else
        {
            navTab.reload(res.heromanager);  //刷新主页面
        }
    }
</script>