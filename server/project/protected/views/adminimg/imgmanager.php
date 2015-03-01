<form id="pagerForm" onsubmit="return navTabSearch(this);" action="<?php echo Yii::app()->createAbsoluteUrl('adminimg/imgmanager'); ?>" method="post">
    <input type="hidden" name="pageNum" value="<?php echo $pages['pageNum'];?>" /><!--【必须】value=1可以写死-->
    <input type="hidden" name="numPerPage" value="50" /><!--【可选】每页显示多少条-->
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" mask="true" height="560" width="600" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminimg/newsadd');?>"><span>添加</span></a></li>
        </ul>
    </div>
    <table class="table" width="1040" layoutH="76">
        <thead>
        <tr>
            <th width="20">编号</th>
            <th width="60">标题</th>
            <th width="180">内容</th>
            <th width="60">添加时间</th>
            <th width="60">添加人</th>
            <th width="40">封面查看</th>
            <th width="40">新闻类型</th>
            <th width="40">评论数量</th>
            <th width="40">点赞数量</th>
            <th width="40">汗数量</th>
            <th width="40">厌恶数量</th>
            <th width="40">新闻来源</th>
            <th width="40">是否为广告</th>
            <th width="80">编辑</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $value) {?>
            <tr>
                <td><?php echo $value['id']; ?></td>
                <td title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></td>
                <td title="<?php echo strip_tags($value['content']); ?>"><?php echo mb_substr(strip_tags($value['content']),0,50,"utf-8");?></td>
                <td><?php echo date("Y-m-d H:i:s", $value['addtime']); ?></td>
                <td><?php echo $value['adduser']; ?></td>
                <td><a href="<?php echo Yii::app()->request->baseUrl.$value['img_url']; ?>" class="btnView" target="_blank">图片查看</a></td>
                <td><?php echo TmpList::$news_list[$value['type']]; ?></td>
                <td><?php echo $value['comment']; ?></td>
                <td><?php echo $value['like']; ?></td>
                <td><?php echo $value['han']; ?></td>
                <td><?php echo $value['hate']; ?></td>
                <td><?php echo $value['source']; ?></td>
                <td><?php echo $value['status']==0?"普通":"广告"; ?></td>
                <td>
                    <a title="确实要删除这条记录吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminimg/newsdel',array('id'=>$value['id'])); ?>" class="btnDel">删除</a>
                    <a title="查看" height="560" mask="true" width="620" target="dialog" href="<?php echo Yii::app()->createAbsoluteUrl('adminimg/newsedit',array('id'=>$value['id'])); ?>" class="btnLook">查看</a>
                    <?php
                    if($value['comtype']==0){
                        ?>
                        <a title="确实要关闭评论吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/gb',array('id'=>$value['id'])); ?>" class="btnSelect">封号</a>
                    <?php }else{ ?>
                        <a title="确实要打开评论吗?" callback="deleteAuCall" target="ajaxTodo" href="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/dk',array('id'=>$value['id'])); ?>" class="btnAssign">解封</a>
                    <?php }?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <span>共<?php echo $pages['countPage'];?>条</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $pages['countPage'];?>" numPerPage="<?php echo $pages['numPerPage'];?>" pageNumShown="10" currentPage="<?php echo $pages['pageNum'];?>"></div>
    </div>
</div>
<script type="text/javascript">
    function deleteAuCall(res)
    {
        if(res.code!=0)
            alertMsg.error(res.msg);
        else
        {
            navTab.reload(res.newsmanager);  //刷新主页面
        }
    }
</script>