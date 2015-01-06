<h2 class="contentTitle">首页设置</h2>
<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/save'); ?>" class="pageForm required-validate" onsubmit="return validateCallback(this,viData)">
        <div class="pageFormContent nowrap" layoutH="97">
            <?php foreach ($models as $value) {?>
            <dl>
                <dt><?php echo $value['text']?></dt>
                <dd>
                    <?php
                    if($value['name']!="contact_us")
                        echo sprintf('<input type="text" name="%s" maxlength="120" size="90" value="%s"/>',$value['name'],$value['value']);
                    else
                        echo sprintf('<textarea class="editor" name="%s" rows="8" cols="50" tools="Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Source,Fullscreen,About">%s</textarea>',$value['name'],$value['value']);
                    ?>
                </dd>
            </dl>
            <?php }?>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo Yii::app()->request->csrfToken; ?>" />
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
        }
    }

</script>
