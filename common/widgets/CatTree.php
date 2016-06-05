<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 27.10.2015
 * Time: 4:02
 */

namespace common\widgets;


use yii\bootstrap\Html;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

class CatTree extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run($cats,$parent_id){
        self::registerCss();
        echo '<div id="tree-wrapper" class="thumbnail tree-wrapper" style="position: relative;">';
        echo self::build_tree($cats,$parent_id);
        echo '</div>';
        self::registerJs();
    }

    private function build_tree($cats,$parent_id,$first = true){
        if(is_array($cats) and isset($cats[$parent_id])){
            if($first == true){
                $tree = '<ul class="ul-treefree ul-dropfree">';
            }else{
                $tree = '<ul>';
            }

                foreach($cats[$parent_id] as $cat){
                    if($cat['parent'] == 0){
                        $tree .= '<li>';
                        $tree .= $cat['name'];
                    }else {
                        $tree .= '<li>';
                        $tree .= '<label style="margin-top: 0px;" class="checkbox" for="cbx-' . $cat['id'] . '">';
                        $tree .= Html::checkbox('cbx[]'.$cat['id'],false,['id'=>'cbx-'.$cat['id'], 'value'=>$cat['id'], 'class'=>'']);
                        $tree .= '<i></i>' . $cat['name'] . '</label>';
                    }
                        $tree .= self::build_tree($cats, $cat['id'], false);
                        $tree .= '</li>';

                }

            $tree .= '</ul>';
        }
        else return null;
        return $tree;
    }

    private function registerCss(){
        $css = <<< CSS
        .tree-wrapper{
            height: 350px;
            overflow: auto;
        }
        /* ul-treefree */
        ul.ul-treefree { padding-left:25px; }
        ul.ul-treefree ul { margin:0; padding-left:6px; }
        ul.ul-treefree li { position:relative; list-style:none outside none; border-left:solid 1px #999; margin:0; padding:0 0 0 19px; line-height:23px; font-size: 14px;}
        ul.ul-treefree li:before { content:''; display:block; border-bottom:solid 1px #999; position:absolute; width:18px; height:11px; left:0; top:0; }
        ul.ul-treefree li:last-child { border-left:0 none; }
        ul.ul-treefree li:last-child:before { border-left:solid 1px #999; }

        /* ul-dropfree */
        ul.ul-dropfree div.drop {
            width:11px;
            height:11px;
            position:absolute;
            z-index:10;
            top:6px;
            left:-6px;
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
            background-position:-11px 0;
            background-repeat:no-repeat;
            cursor:pointer;
        }

CSS;
        $this->registerCss($css);
    }

    private  function registerJs(){
        $js = <<< JS
    $(document).ready(function(){
        $(".ul-dropfree").find("li:has(ul)").prepend('<div class="drop"></div>');
        $(".ul-dropfree div.drop").click(function() {
            if ($(this).nextAll("ul").css('display')=='none') {
                $(this).nextAll("ul").slideDown(400);
                $(this).css({'background-position':"-11px 0"});
            } else {
                $(this).nextAll("ul").slideUp(400);
                $(this).css({'background-position':"0 0"});
            }
        });
	    $(".ul-dropfree").find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position':"0 0"});
    });
JS;
        $this->registerJsFile('js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile('js/jquery.form.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJs($js, View::POS_END);
    }



}