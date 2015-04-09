<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/newsupdate'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>新闻类型：</label>
                <select class="combox" name="news_type">
                    <?php foreach(TmpList::$news_list as $k=>$val){
                        if($k==8||$k==5||$k==2)continue;
                        printf('<option value="%s" %s>%s</option>',$k,$models->type==$k?"selected":"",$val);
                    } ?>
                </select>
            </p>
            <p>
                <label>新闻状态：</label>
                <select class="combox" name="news_status">
                    <option value="0" <?php echo $models->status==0?"selected":"";?>>普通</option>
                    <option value="1" <?php echo $models->status==1?"selected":"";?>>广告</option>
                </select>
            </p>
            <p class="nowrap">
                <label>评论,赞,汗,厌：</label>
                <input  name="news_comment" type="text" class="required" size="2" value="<?php echo $models->comment;?>">
                <input  name="news_like" type="text" class="required" size="2" value="<?php echo $models->like;?>">
                <input  name="news_han" type="text" class="required" size="2" value="<?php echo $models->han;?>">
                <input  name="news_hate" type="text" class="required" size="2" value="<?php echo $models->hate;?>">
            </p>
            <?php if($models->img_url!=""){?><p class="nowrap"><label>封面图片：</label><img width="120" height="120" src="<?php echo Yii::app()->request->baseUrl.$models->img_url;?>"></p>
            <?php }?>
            <p class="nowrap">
                <label>封面图片上传：</label>
                <input name="news_up" type="file">
            </p>
            <p class="nowrap">
                <label>标题：</label>
                <input  name="news_title" type="text" class="textInput required" size="50" value="<?php echo $models->title;?>">
                <input  name="id" type="hidden" value="<?php echo $models->id;?>">
            </p>
            <p class="nowrap">
                <label>来源：</label>
                <input  name="news_source" type="text" class="textInput required" size="50" value="<?php echo $models->source;?>">
            </p>
            <p>
                <textarea class="editor" upImgUrl="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/imgupload'); ?>" upImgExt="jpg,jpeg,gif,png" name="news_content" rows="21" cols="79" ><?php echo $models->content;?></textarea>
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