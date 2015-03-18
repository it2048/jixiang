<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/slideupdate'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>广告类型：</label>
                <select class="combox" name="slide_type">
                    <option value="0" <?php echo $models->type==0?"selected":"";?>>首页</option>
                    <option value="1" <?php echo $models->type==1?"selected":"";?>>iOS引导</option>
                    <option value="2" <?php echo $models->type==2?"selected":"";?>>安卓引导</option>
                </select>
            </p>
            <p class="nowrap">
                <label>广告标题：</label>
                <input  name="slide_title" type="text" class="textInput required" size="50" value="<?php echo $models->title;?>">
                <input  name="id" type="hidden" value="<?php echo $models->id;?>">
            </p>
            <?php if($models->img_url!=""){?><p class="nowrap"><label>封面图片：</label><img width="120" height="120" src="<?php echo Yii::app()->request->baseUrl.$models->img_url;?>"></p>
            <?php }?>
            <p class="nowrap">
                <label>更换封面图片：</label>
                <input name="slide_up" type="file">
            </p>
            <p class="nowrap">
                <label>跳转新闻编号：</label>
                <input  name="slide_redirect" type="text" class="textInput" size="50" value="<?php echo $models->newsid;?>">
            </p>
            <p class="nowrap">
                <label>开始时间：</label>
                <input type="text" name="slide_stime" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true" value="<?php echo empty($models->stime)?date("Y-m-d H:i:s",time()):date("Y-m-d H:i:s",$models->stime); ?>"/>
            </p>
            <p class="nowrap">
                <label>结束时间：</label>
                <input type="text" name="slide_etime" class="date" dateFmt="yyyy-MM-dd HH:mm:ss" readonly="true" value="<?php echo empty($models->etime)?date("Y-m-d H:i:s",time()):date("Y-m-d H:i:s",$models->etime); ?>"/>

            </p>
        </div>
        <div class="formBar">
            <ul>
                <!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">更新</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
<script type="text/javascript">
    /**
     * 回调函数
     */
    function viData(json) {
        if(json.code!=0)
        {
            alertMsg.error(json.msg); //返回错误
        }
        else
        {
            alertMsg.correct("更新成功"); //返回错误
            navTab.reload(json.slidemanager);  //刷新主页面
            $.pdialog.closeCurrent();  //
        }
    }

</script>