<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/videosave'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>资料类型：</label>
                <select class="combox" name="video_type">
                    <option value="0" selected>图片</option>
                    <option value="1">视频</option>
                </select>
            </p>
            <p class="nowrap">
                <label>资料名称：</label>
                <input  name="video_title" type="text" class="textInput required" size="50" value="">
            </p>
            <p class="nowrap">
                <label>资料封面地址：</label>
                <input name="video_img" type="text" class="textInput" size="50" value="">
            </p>
            <p class="nowrap">
                <label>资料封面上传：</label>
                <input name="video_up" type="file">
            </p>
            <p class="nowrap">
                <label>资料地址：</label>
                <input name="vedio_path" type="text" class="textInput" size="50" value="">
            </p>
            <p class="nowrap">
                <label>资料上传：</label>
                <input name="video_url" type="file">
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
            navTab.reload(json.videomaneger);  //刷新主页面
            $.pdialog.closeCurrent();  //
        }
    }

</script>