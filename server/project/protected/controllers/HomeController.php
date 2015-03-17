<?php

class HomeController extends Controller {

    public $layout = '//layouts/home';

    /**
     * 生成首页
     * 
     */
    public function actionIndex() {
        $id = Yii::app()->getRequest()->getParam("id", "");
        if ($id == "") {
            echo "404 文章不存在啊！";
        } else {
            $row = AppJxNews::model()->findByPk($id);
            if (!empty($row)) {
                $src = $row['source'];
                if (strpos($row['source'], "《") !== false) {
                    $src = ltrim($src, "《");
                }
                if (strpos($row['source'], "》") !== false) {
                    $src = rtrim($src, "》");
                }
                $content = str_replace("<img ", "<img width='100%' ", $row['content']);
                $img = $this->img_revert($row['img_url']);
                if(!empty($img))
                    $content = '<img src="'.$img.'" />'.$content;
                $data = array("addtime" => date("Y-m-d H:i",$row['addtime']), "title" => $row['title']
                    , "img_url" => $this->img_revert($row['img_url'])
                    , "source" => $src
                    ,"type"=>TmpList::$news_list[$row->type]
                );
                if ($row->type != 2) {
                    $data['content'] = $content;
                }else
                {
                    if(!empty($row['child_list']))
                    {
                        $rowLs = AppJxNews::model()->findAll("id in(".$row['child_list'].")");
                        foreach ($rowLs as $val) {
                            $img = $this->img_revert($row['img_url']);
                            if(!empty($img))
                                $val['content'] = '<img src="'.$img.'" />'.$val['content'];
                            $data['content'] .= $val['content'];
                        }
                    }
                }
                $this->render('index',array("model"=>$data));
            }
            else
            {
                echo "404 文章不存在啊！";
            }
        }
    }

    protected function img_revert($str)
    {
        if(trim($str)=="")
        {
            return "";
        }else{
            return "http://120.24.234.19".Yii::app()->request->baseUrl.$str;
        }
    }
}
