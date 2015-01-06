<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/herosave'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p>
                <label>英雄职业：</label>
                <select class="combox" name="hero_type">
                    <option value="0" selected>力量</option>
                    <option value="1">敏捷</option>
                    <option value="2">智力</option>
                </select>
            </p>
            <p class="nowrap">
                <label>力,敏,智,星,属性：</label>
                <input  name="hero_strong" type="text" class="required" size="2" value="">
                <input  name="hero_agile" type="text" class="required" size="2" value="">
                <input  name="hero_intelligence" type="text" class="required" size="2" value="">
                <select class="combox" name="hero_star">
                    <option value="1" selected>1星</option>
                    <option value="2">2星</option>
                    <option value="3">3星</option>
                    <option value="4">4星</option>
                    <option value="5">5星</option>
                </select>
                <input  name="hero_virtue" type="text" class="required" size="2" value="">
            </p>
                <p class="nowrap">
                    <label>英雄图片替换：</label>
                    <input name="hero_img" type="file">
                </p>
            <p class="nowrap">
                <label>英雄名称：</label>
                <input  name="hero_name" type="text" class="textInput required" size="30" value="">
            </p>
                <p class="nowrap">
                    <label>技能1：</label>
                    <input name="hero_jn1" type="file">
                </p>
                <p class="nowrap">
                    <label>技能1描述：</label>
                    <textarea name="hero_jnt1" cols="50" rows="2"></textarea>
                </p>
                <p class="nowrap">
                    <label>技能2：</label>
                    <input name="hero_jn2" type="file">
                </p>
                <p class="nowrap">
                    <label>技能2描述：</label>
                    <textarea name="hero_jnt2" cols="50" rows="2"></textarea>
                </p>
                <p class="nowrap">
                    <label>技能3：</label>
                    <input name="hero_jn3" type="file">
                </p>
                <p class="nowrap">
                    <label>技能3描述：</label>
                    <textarea name="hero_jnt3" cols="50" rows="2"></textarea>
                </p>
                <p class="nowrap">
                    <label>技能4：</label>
                    <input name="hero_jn4" type="file">
                </p>
                <p class="nowrap">
                    <label>技能4描述：</label>
                    <textarea name="hero_jnt4" cols="50" rows="2"></textarea>
                </p>
                <p class="nowrap">
                    <label>技能5：</label>
                    <input name="hero_jn5" type="file">
                </p>
                <p class="nowrap">
                    <label>技能5描述：</label>
                    <textarea name="hero_jnt5" cols="50" rows="2"></textarea>
                </p>
                <p class="nowrap">
                    <label>技能6：</label>
                    <input name="hero_jn6" type="file">
                </p>
                <p class="nowrap">
                    <label>技能6描述：</label>
                    <textarea name="hero_jnt6" cols="50" rows="2"></textarea>
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
            navTab.reload(json.heromaneger);  //刷新主页面
            $.pdialog.closeCurrent();  //
        }
    }

</script>