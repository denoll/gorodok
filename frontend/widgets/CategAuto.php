<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 11.06.2015
 * Time: 18:45
 */

namespace frontend\widgets;

use common\models\konkurs\Konkurs;
use common\models\konkurs\KonkursItem;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use yii\web\View;
use common\models\konkurs\KonkursCat;
use common\widgets\Arrays;

class CategAuto extends Widget
{
	public $level;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$id_konkurs = Yii::$app->session->get('id_konkurs');
		$cat = $this->getData();
		$this->registerCss();
		echo '<div style="display: block; content: \' \'; padding: 2px; margin: 5px 0px; background-color: #d9d9d9;">';
		echo '<div  style="margin: 0px 0px 2px 0px; width: 100%; display: block; background-color: #9C0000; padding: 7px 18px;">';
		echo '<h3 style="margin: 0; color: #fff;">';
		echo Html::a('<i class="fa fa-konkurspaper-o"></i>&nbsp;&nbsp;Все авто', [ '/auto/item/index' ], [ 'style' => 'color:#fff; text-decoration:none; font-size: 0.9em;' ]);
		echo '</h3>';
		echo '</div>';
		echo Html::a('<i class="fa fa-plus"></i>&nbsp;&nbsp;Подать объявление', [ '/auto/item/create' ],
			[ 'class' => 'btn-u btn-u-orange cat-button', 'style' => 'padding: 5px 7px 5px 7px; text-align:center; font-size:15px; width:100%;' ]
		);
		echo '<div id="vertical" class="hovermenu ttmenu dark-style menu-color-gradient" style="margin: 0px 0px 0px 0px;">';
		echo '<div class="navbar navbar-default" role="navigation" style="margin: 0;">';
		echo '<div class="navbar-header">';
		echo '<button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button">';
		echo '<a class="navbar-brand" href="#">';
		echo '<i class="fa fa-bars">&nbsp;&nbsp;Все авто</i>';
		echo '</a>';
		echo '</div>';

		echo '<div id="v-menu" class="navbar-collapse collapse">';

		echo $this->tree($cat);

		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		$this->registerJs();
	}

	private function getData()
	{
		return [
			[
				'name' => 'Автомобили',
				'slug' => 'auto',
			],
		];
	}

	private function activeCategory()
	{
		$cat = Yii::$app->request->get('cat');
		if ( !empty($cat) ) {
			return $cat;
		} else {
			return null;
		}
	}

	private function tree($cat)
	{
		$activ_el = self::activeCategory();
		$path = Url::to('/');
		echo '<ul class="nav navbar-nav">';
		foreach ( $cat as $node ) {
			if ( $node[ 'lvl' ] == 0 ) {
				echo '<li class="dropdown">';
				if ( $node[ 'slug' ] == $activ_el ) {
					echo Html::a($node[ 'name' ] . '<b class="dropme"></b>', [ $path.$node[ 'slug' ] ], [ 'data-toggle' => 'dropdown', 'class' => 'dropdown-toggle active' ]);
				} else {
					echo Html::a($node[ 'name' ] . '<b class="dropme"></b>', [ $path.$node[ 'slug' ] ], [ 'data-toggle' => 'dropdown', 'class' => 'dropdown-toggle' ]);
				}
				echo '</li>';
			}
		}
		echo '</ul>';
	}

	private function registerCss()
	{
		$this->view->registerCssFile('/css/menu/menu.css', [ 'depends' => [ \yii\web\YiiAsset::className() ] ]);
	}

	private function registerJs()
	{
		$js = <<< JS
    $(document).ready(function () {

});
JS;
		$this->view->registerJsFile('/js/menu/ttmenu.js', [ 'depends' => [ \yii\web\JqueryAsset::className() ] ]);
		$this->view->registerJsFile('/js/menu/jquery.fitvids.js', [ 'depends' => [ \yii\web\JqueryAsset::className() ] ]);
		$this->view->registerJsFile('/js/menu/hovernav.js', [ 'depends' => [ \yii\web\JqueryAsset::className() ] ]);
		$this->view->registerJs($js, View::POS_END);
	}
}

?>