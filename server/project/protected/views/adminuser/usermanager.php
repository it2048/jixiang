<form onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('adminuser/usermanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <table class="table" width="1040" layoutH="46">
        <thead>
        <tr>
            <th width="20">编号</th>
            <th width="90">手机</th>
            <th width="60">昵称</th>
            <th width="60">头像</th>
            <th width="40">状态</th>
            <th width="90">封号时间</th>
            <th width="90">创建时间</th>
            <th width="180">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $value) {?>
            <tr>
                <td><?php echo $value['id']; ?></td>
                <td><?php echo $value['tel']; ?></td>
                <td><?php echo $value['uname']; ?></td>
                <td><a href="<?php echo Yii::app()->request->baseUrl.$value['img_url']; ?>" class="btnView" target="_blank">头像查看</a></td>
                <td><?php echo $value['type']==1?"封号":"正常"; ?></td>
                <td><?php echo empty($value['fhtime'])?"":date("Y-m-d H:i:s", $value['fhtime']); ?></td>
                <td><?php echo date("Y-m-d H:i:s", $value['ctime']); ?></td>
                <td>
                    <a title="确实要删除这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminuser/userdel',array('id'=>$value['id'])); ?>" class="btnDel">删除</a>
                    <?php 
                    if($value['type']==0){
                    ?>
                    <a title="确实要封号吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminuser/userfh',array('id'=>$value['id'])); ?>" class="btnEdit">封号</a>
                    <?php }else{ ?>
                    <a title="确实要解封吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminuser/userjf',array('id'=>$value['id'])); ?>" class="btnEdit">解封</a>
                    <?php }?>
                    <a title="确实要重置密码为123456吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminuser/usermm',array('id'=>$value['id'])); ?>" class="btnAssign">重置密码</a>
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
            navTab.reload(res.usermanager);  //刷新主页面
        }
    }
</script>