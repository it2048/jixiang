<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/newsupdate'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>新闻类型：</label>
                <select class="combox" name="news_type">
                    <?php foreach(TmpList::$news_list as $k=>$val){
                        printf('<option value="%s" %s>%s</option>',$k,$models->type==$k?"selected":"",$val);
                    } ?>
                </select>
            </p>
            <p class="nowrap">
                <label>评论,赞,汗,厌：</label>
                <input  name="news_comment" type="text" class="required" size="2" value="<?php echo $models->comment;?>">
                <input  name="news_like" type="text" class="required" size="2" value="<?php echo $models->like;?>">
                <input  name="news_han" type="text" class="required" size="2" value="<?php echo $models->han;?>">
                <input  name="news_hate" type="text" class="required" size="2" value="<?php echo $models->hate;?>">
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
            <?php 
             $str = '<tr>';
             foreach ($mdd as $key => $value) {
                 if($key%4==0)
                 {
                     $str .= '</tr><tr>';
                 }
                 $str .= sprintf('<td><img src="%s%s" width="128" height="100"><br><input name="desc0" type="text" class="textInput" size="16" value="%s"></td>',Yii::app()->request->baseUrl,$value['img_url'],$value['content']);
             }
             $str .= '</tr>';
             echo $str;
            ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>