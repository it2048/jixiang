<form onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/videomanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" mask="true" height="460" width="600" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/videoadd');?>"><span>添加图片视频资料</span></a></li>
        </ul>
    </div>
    <table class="table" width="960" layoutH="76">
        <thead>
        <tr>
            <th width="20">编号</th>
            <th width="160">标题</th>
            <th width="40">封面地址</th>
            <th width="40">资料地址</th>
            <th width="40">资料类型</th>
            <th width="40">添加人</th>
            <th width="60">添加时间</th>
            <th width="40">是否发布</th>
            <th width="80">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $value) {?>
            <tr>
                <td><?php echo $value['id']; ?></td>
                <td title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></td>
                <td><a href="<?php echo Yii::app()->request->baseUrl.$value['img_url']; ?>" class="btnView" target="_blank">封面查看</a></td>
                <td><a href="<?php echo Yii::app()->request->baseUrl.$value['video_url']; ?>" class="btnView" target="_blank">资料查看</a></td>
                <td><?php echo $value['type']==0?"图片":"视频"; ?></td>
                <td><?php echo $value['add_user']; ?></td>
                <td><?php echo date("Y-m-d H:i:s", $value['add_time']); ?></td>
                 <td><?php echo $value['publish']==1?"已发布":"<p style='color:red;margin-top:3px;'>未发布</p>"; ?></td>
                <td>
                    <a title="确实要删除这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/videodel',array('id'=>$value['id'])); ?>" class="btnDel">删除</a>
                    <a title="编辑" height="560" mask="true" width="620" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/videoedit',array('id'=>$value['id'])); ?>" class="btnEdit">编辑</a>
                    <a title="确实要<?php echo $value['publish']==0?"发布":"取消发布"; ?>这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php
                    echo Yii::app()->createAbsoluteUrl('adminhomeset/videopublish',array('id'=>$value['id'])); ?>" class="<?php echo $value['publish']==0?"btnSelect":"btnAttach"; ?>"><?php echo $value['publish']==0?"发布":"取消发布"; ?></a>
                </td>
            </tr>
        <?php }?>
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
            navTab.reload(res.videomanager);  //刷新主页面
        }
    }
</script>