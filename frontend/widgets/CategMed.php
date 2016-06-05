<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 20.06.2015
 * Time: 23:11
 */

namespace frontend\widgets;

use Yii;
use \yii\bootstrap\Html;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;
use \yii\bootstrap\BootstrapAsset;
use \yii\bootstrap\Dropdown;
use \yii\helpers\Url;
use common\models\med\VDoctors;

class CategMed extends Widget
{
	public $cats;

	public function init()
	{
		parent::init();
	}

	public function run($cats)
	{

		$is_company = $this->params['is_company'];
		$is_doctor = $this->params['is_doctor'];
		$cats = empty($this->cats) ? null : $this->cats;

		$this->registerCss();
		echo '<div class="left-cat">';
		echo '<h2 class="left-cat-header">';
		echo '<i class="fa fa-hospital-o"></i>';
		echo '<span style="padding-left: 9px;">Специализации: </span>';
		echo '</h2>';

		if (!$is_company) {
			if ($is_doctor) {
				echo Html::a('<i class="fa fa-edit"></i>&nbsp;&nbsp;Редактировать свои медицинские данные', ['/med/doctors/update'], ['class' => 'btn-u btn-u-orange', 'style' => 'padding: 9px 2px 9px 10px; font-size:1em; width:100%;']);
			} else {
				echo Html::a('<i class="fa fa-user-md"></i>&nbsp;&nbsp;Я врач, и хочу появиться на сайте', ['/med/doctors/create'], ['class' => 'btn-u btn-u-orange', 'style' => 'padding: 9px 2px 9px 10px; font-size:1em; width:100%;']);
			}
		}
		echo '</div>';
		echo '<div class="thumbnail" style="margin: 0; padding: 1px; border-color: #A90000;">';


		echo '<div class="nano has-scrollbar" style="margin: 0px 0px 5px 0px; padding-right: 0px !important; display: block;">';


		echo '<div id="cat-wrapper" class="cat-wrapper nano-content" style="position: relative;">';

		echo $this->buildTreeCat($cats);

		echo '</div>';
		echo '</div>';
		echo '</div>';
		$this->registerJs();
	}

	private function buildTreeCat($cats = null)
	{
		if ($cats != null) {
			$path = Url::home() . 'med/doctors/index';
			$tree = '<ul class="ul-cat">';
			foreach ($cats as $cat) {
				$tree .= '<li class="" style="margin: 0px;">';
				$tree .= '<i></i>' . Html::a($cat['name'], [$path, 'cat' => $cat['id']]) . '</label>';
				$tree .= '</li>';
			}
			$tree .= '</ul>';
			return $tree;
		} else {
			return false;
		}
	}

	private function registerCss()
	{
		$css = <<< CSS

        .nano {
          position : relative;
          width    : 100%;
          height   : 100%;
          overflow : hidden;
        }
        .nano > .nano-content {
          position      : absolute;
          overflow      : scroll;
          overflow-x    : hidden;
          top           : 0;
          right         : 0;
          bottom        : 0;
          left          : 0;
        }
        .nano > .nano-content:focus {
          outline: thin dotted;
        }
        .nano > .nano-content::-webkit-scrollbar {
          display: none;
        }
        .has-scrollbar > .nano-content::-webkit-scrollbar {
          display: block;
        }
        .nano > .nano-pane {
          background : rgba(0,0,0,.15);
          position   : absolute;
          width      : 10px;
          right      : 0;
          top        : 0;
          bottom     : 0;
          visibility : hidden\9; /* Target only IE7 and IE8 with this hack */
          opacity    : .01;
          -webkit-transition    : .2s;
          -moz-transition       : .2s;
          -o-transition         : .2s;
          transition            : .2s;
          -moz-border-radius    : 5px;
          -webkit-border-radius : 5px;
          border-radius         : 5px;
        }
        .nano > .nano-pane > .nano-slider {
          background: #444;
          background: rgba(0,0,0,.5);
          position              : relative;
          margin                : 0 2px;
          -moz-border-radius    : 3px;
          -webkit-border-radius : 3px;
          border-radius         : 3px;
        }
        .nano:hover > .nano-pane, .nano-pane.active, .nano-pane.flashed {
          visibility : visible\9; /* Target only IE7 and IE8 with this hack */
          opacity    : 0.99;
        }

        .cat-wrapper{
            height: 450px;
            overflow: auto;
            margin-top: 0px;
        }
        /* ul-cat */
        ul.ul-cat { padding-left:10px; }

        ul.ul-cat li {
            position:relative;
            list-style:none outside none;

            margin:0;
            padding:3px 0px;
            line-height:16px;
            font-size: 12px;
        }
        ul.ul-cat li:before {
            content:'';
            display:block;
            position:absolute;
            width:18px;
            height:11px;
            left:0;
            top:0;
        }
        ul.ul-cat li:last-child {  }
        ul.ul-cat li:last-child:before {  }


CSS;

		$this->view->registerCss($css);
	}

	private function registerJs()
	{
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

	    $(function(){
            $('.nano').nanoScroller({
                scroll: 'top'
            });
        });
    });
JS;
		$this->view->registerJsFile('js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
		$this->view->registerJsFile('js/jquery.form.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
		$this->view->registerJsFile('js/scroll/jquery.nanoscroller.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
		$this->view->registerJs($js, View::POS_END);
	}
}
