<form onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('admincomment/commentmanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <table class="table" width="1040" layoutH="46">
        <thead>
        <tr>
            <th width="20">编号</th>
            <th width="90">新闻标题</th>
            <th width="60">用户帐号</th>
            <th width="60">回复内容</th>
            <th width="40">回复人帐号</th>
            <th width="90">评论时间</th>
            <th width="80">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $value) {?>
            <tr>
                <td><?php echo $value['id']; ?></td>
                <td><?php echo $newApp[$value['news_id']]; ?></td>
                <td><?php echo $userApp[$value['user_id']]; ?></td>
                <td><?php echo $value['comment']; ?></td>
                <td><?php echo $value['parent_user']; ?></td>
                <td><?php echo date("Y-m-d H:i:s", $value['addtime']); ?></td>
                <td>
                    <a title="确实要删除这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('admincomment/commentdel',array('id'=>$value['id'])); ?>" class="btnDel">删除</a>
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
            navTab.reload(res.commentmanager);  //刷新主页面
        }
    }
</script>