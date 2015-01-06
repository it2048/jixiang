<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/newsupdate'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>文章类型：</label>
                <select class="combox" name="news_type">
                    <option value="0" <?php echo $models->type==0?"selected":"";?>>新闻</option>
                    <option value="1" <?php echo $models->type==1?"selected":"";?>>公告</option>
                    <option value="2" <?php echo $models->type==2?"selected":"";?>>活动</option>
                    <option value="3" <?php echo $models->type==3?"selected":"";?>>新手指导</option>
                    <option value="4" <?php echo $models->type==4?"selected":"";?>>系统玩法</option>
                    <option value="5" <?php echo $models->type==5?"selected":"";?>>特色玩法</option>
                </select>
            </p>
            <p>
                <label>文章状态：</label>
                <select class="combox" name="news_status">
                    <option value="0" <?php echo $models->status==0?"selected":"";?>>普通</option>
                    <option value="1" <?php echo $models->status==1?"selected":"";?>>置顶</option>
                </select>
            </p>
            <p class="nowrap">
                <label>标题：</label>
                <input  name="news_title" type="text" class="textInput required" size="50" value="<?php echo $models->title;?>">
                <input  name="id" type="hidden" value="<?php echo $models->id;?>">
            </p>
            <p>
                <textarea class="editor" upImgUrl="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/imgupload'); ?>" upImgExt="jpg,jpeg,gif,png" name="news_content" rows="21" cols="79"><?php echo $models->content;?></textarea>
            </p>
        </div>
        <div class="formBar">
            <ul>
                <!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
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
            alertMsg.correct("保存成功"); //返回错误
            navTab.reload(json.usermaneger);  //刷新主页面
            $.pdialog.closeCurrent();  //
        }
    }

</script>