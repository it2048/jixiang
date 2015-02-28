<style type="text/css">
    .uploadify-queue{ display: none;
    }
</style>
<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminimg/save'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p class="nowrap">
                <label>标题：</label>
                <input  name="news_title" id="news_title" type="text" class="textInput required" size="50" value="">
            </p>
            <p class="nowrap">
                <label>来源：</label>
                <input  name="news_source" id="news_source" type="text" class="textInput" size="50" value="">
            </p>
            <div class="divider"></div>
            <p class="nowrap">
                <div style="float: left;">
                <label>说明：</label>
                <input  name="news_desc" id="news_desc"  type="text" class="textInput" size="40" value="">
                </div>
                <div style="float: right;">
                <input id="testFileInput" type="file" name="image"/>
                </div>
            </p>
            <div class="divider"></div>
            <div id="test">
                <table class="list" width="560">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
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
    $(function() {
        var _id = 0;
        $("#testFileInput").uploadify({
            'swf':'<?php echo Yii::app()->request->baseUrl; ?>/admincss/dwzthemes/uploadify/scripts/uploadify.swf',
            'uploader':'<?php echo Yii::app()->createAbsoluteUrl('adminimg/imgsave'); ?>',
            'formData':{'news_title':"", 'news_desc':"",'news_source':""},
            'buttonText':'添加图片',
            'fileTypeDesc':'*.jpg;*.jpeg;*.gif;*.png;',
            'fileTypeExts':'*.jpg;*.jpeg;*.gif;*.png;',
            'height':20,
            'onUploadSuccess' : function(file, data, response) {

                var desc = $.trim($("#news_desc").val());
                json = jQuery.parseJSON(data);
                if(json.statusCode==200)
                {
                    if(_id%4==0)
                    {
                        $("#tbody").append('<tr><td id="td'+_id+'"><img src="<?php echo Yii::app()->request->baseUrl;?>'+json.img+'" width="128" height="100" /><input name="url'+_id+'" type="hidden" value="'+json.img+'"><br/><input name="desc'+_id+'" type="text" class="textInput" size="16" value="'+desc+'"><br/><button type="button" onclick="deletetd(\''+json.rel+'\',\''+_id+'\')">删除</button></td></tr>');
                    }else
                    {
                        $("#td"+(_id-1)).after('<td id="td'+_id+'"><img src="<?php echo Yii::app()->request->baseUrl;?>'+json.img+'" width="128" height="100" /><input name="url'+_id+'" type="hidden" value="'+json.img+'"><br/><input name="desc'+_id+'" type="text" class="textInput" size="16" value="'+desc+'"><br/><button type="button" onclick="deletetd(\''+json.rel+'\',\''+_id+'\')">删除</button></td>');
                    }
                    _id++;
                }
            }
        });
    });

    function deletetd(ul,id)
    {
        var url = '<?php echo Yii::app()->createAbsoluteUrl('adminimg/imgdel'); ?>/ph/'+ul;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "json",
            success: function(data) {
                if(data.code!=0)
                {
                    alertMsg.error(data.msg); //返回错误
                }else
                {
                    $("#td"+(id)).html("");
                }
            }
        });
    }
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