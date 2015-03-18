<form onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/slidemanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" mask="true" height="460" width="600" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/slideadd');?>"><span>添加广告位</span></a></li>
        </ul>
    </div>
    <table class="table" width="960" layoutH="76">
        <thead>
        <tr>
            <th width="20">编号</th>
            <th width="60">标题</th>
            <th width="20">图片</th>
            <th width="20">跳转id</th>
            <th width="60">开始时间</th>
            <th width="60">结束时间</th>
            <th width="40">类型</th>
            <th width="40">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $value) {?>
            <tr>
                <td><?php echo $value['id']; ?></td>
                <td title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></td>
                <td><?php if(!empty($value['img_url'])){?><a href="<?php echo Yii::app()->request->baseUrl.$value['img_url']; ?>" class="btnLook" target="_blank">图片查看</a><?php }?></td>
                <td><?php echo $value['newsid']; ?></td>
                <td><?php echo date("Y-m-d H:i:s", $value['stime']); ?></td>
                <td><?php echo date("Y-m-d H:i:s", $value['etime']); ?></td>
                <td><?php echo TmpList::$news_type[$value['type']]; ?></td>
                <td>
                    <a title="确实要删除这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/slidedel',array('id'=>$value['id'])); ?>" class="btnDel">删除</a>
                    <a title="编辑" mask="true" height="560" width="620" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/slideedit',array('id'=>$value['id'])); ?>" class="btnEdit">编辑</a>

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
            alertMsg.error("删除失败");
        else
        {
            navTab.reload(res.slidemanager);  //刷新主页面
        }
    }
</script>