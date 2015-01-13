<form onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('admindegree/degreemanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <table class="table" width="1040" layoutH="46">
        <thead>
        <tr>
            <th width="20">新闻</th>
            <th width="90">用户</th>
            <th width="60">操作</th>
            <th width="80">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $value) {?>
            <tr>
                <td><?php echo $newApp[$value['news_id']]; ?></td>
                <td><?php echo $userApp[$value['user_id']]; ?></td>
                <td><?php $arr=array(1=>"赞",2=>"汗",3=>"厌"); echo $arr[$value['type']]; ?></td>
                <td>
                    <a title="确实要删除这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('admindegree/degreedel',
                        array('news_id'=>$value['news_id'],'user_id'=>$value['user_id'])); ?>" class="btnDel">删除</a>
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
            navTab.reload(res.degreemanager);  //刷新主页面
        }
    }
</script>