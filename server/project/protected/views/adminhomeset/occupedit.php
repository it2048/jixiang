<div class="pageContent">
    <form method="post" action="<?php echo Yii::app()->createAbsoluteUrl('adminhomeset/occupupdate'); ?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, viData);" enctype="multipart/form-data">
        <div class="pageFormContent" layoutH="56">
            <p class="nowrap">
                <label>职业图片替换：</label>
                <input name="occup_img" type="file">
                <input  name="id" type="hidden" value="<?php echo $models->id;?>">
            </p>
            <p class="nowrap">
                <label>属性,武器,攻击：</label>
                <select class="combox" name="occup_sx">
                    <option value="力量" <?php echo $models->sx=="力量"?"selected":"";?>>力量</option>
                    <option value="敏捷" <?php echo $models->sx=="敏捷"?"selected":"";?>>敏捷</option>
                    <option value="智力" <?php echo $models->sx=="智力"?"selected":"";?>>智力</option>
                </select>
                <input  name="occup_wq" type="text" class="required" size="2" value="<?php echo $models->wq;?>">
                <input  name="occup_gj" type="text" class="required" size="2" value="<?php echo $models->gj;?>">
            </p>
            <p class="nowrap">
                <label>简要描述：</label>
                <textarea name="occup_desc" cols="50" rows="4"><?php echo $models->description;?></textarea>
            </p>
            <p class="nowrap">
                <label>职业特点：</label>
                <textarea name="occup_td" cols="50" rows="4"><?php echo $models->td;?></textarea>
            </p>
            <p class="nowrap">
                <label>技能1名称：</label>
                <input name="occup_jname1" type="text" <?php echo $models->jname1;?>>
            </p>
            <p class="nowrap">
                <label>技能1：</label>
                <input name="occup_jn1" type="file">
            </p>
            <p class="nowrap">
                <label>技能1描述：</label>
                <textarea name="occup_jnt1" cols="50" rows="2"><?php echo $models->jnt1;?></textarea>
            </p>
            <p class="nowrap">
                <label>技能2名称：</label>
                <input name="occup_jname2" type="text" <?php echo $models->jname2;?>>
            </p>
            <p class="nowrap">
                <label>技能2：</label>
                <input name="occup_jn2" type="file">
            </p>
            <p class="nowrap">
                <label>技能2描述：</label>
                <textarea name="occup_jnt2" cols="50" rows="2"><?php echo $models->jnt2;?></textarea>
            </p>
            <p class="nowrap">
                <label>技能3名称：</label>
                <input name="occup_jname3" type="text" <?php echo $models->jname3;?>>
            </p>
            <p class="nowrap">
                <label>技能3：</label>
                <input name="occup_jn3" type="file">
            </p>
            <p class="nowrap">
                <label>技能3描述：</label>
                <textarea name="occup_jnt3" cols="50" rows="2"><?php echo $models->jnt3;?></textarea>
            </p>

            <p class="nowrap">
                <label>技能4名称：</label>
                <input name="occup_jname4" type="text" <?php echo $models->jname4;?>>
            </p>
            <p class="nowrap">
                <label>技能4：</label>
                <input name="occup_jn4" type="file">
            </p>
            <p class="nowrap">
                <label>技能4描述：</label>
                <textarea name="occup_jnt4" cols="50" rows="2"><?php echo $models->jnt4;?></textarea>
            </p>
            <p class="nowrap">
                <label>技能5名称：</label>
                <input name="occup_jname5" type="text" <?php echo $models->jname5;?>>
            </p>
            <p class="nowrap">
                <label>技能5：</label>
                <input name="occup_jn5" type="file">
            </p>
            <p class="nowrap">
                <label>技能5描述：</label>
                <textarea name="occup_jnt5" cols="50" rows="2"><?php echo $models->jnt5;?></textarea>
            </p>
            <p class="nowrap">
                <label>技能6名称：</label>
                <input name="occup_jname6" type="text" <?php echo $models->jname6;?>>
            </p>
            <p class="nowrap">
                <label>技能6：</label>
                <input name="occup_jn6" type="file">
            </p>
            <p class="nowrap">
                <label>技能6描述：</label>
                <textarea name="occup_jnt6" cols="50" rows="2"><?php echo $models->jnt6;?></textarea>
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
            navTab.reload(json.occupmaneger);  //刷新主页面
            $.pdialog.closeCurrent();  //
        }
    }

</script>