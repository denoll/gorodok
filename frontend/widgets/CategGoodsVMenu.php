<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 11.06.2015
 * Time: 18:45
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use \yii\bootstrap\Widget;
use common\models\goods\GoodsCat;

class CategGoodsVMenu extends Widget
{

	public $level;

	public function init()
	{

	}

	public function run()
	{
		$level = empty($this->level) ? 0 : $this->level;
		$cat = GoodsCat::find()
			->select(['id', 'root', 'lft', 'rgt', 'lvl', 'name', 'icon', 'alias'])
			->where(['active' => 1, 'visible' => 1])
			->asArray()
			->orderBy('lft')
			->orderBy('root')
			->all();
		$this->registerCssLoc();
		echo '<div class="v-menu">';
		echo '<div class="v-menu-header">';
		echo '<h3 style="margin: 0; color: #fff;">';
		echo Html::a('<i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;Каталог товаров', ['/goods/goods/index'], ['style' => 'color:#fff; text-decoration:none; font-size: 0.9em;']);
		echo '</h3>';
		echo '</div>';
		echo Html::a('<i class="fa fa-plus"></i>&nbsp;&nbsp;Подать объявление', ['/goods/goods/create'], ['class' => 'btn-u btn-u-orange cat-button', 'style' => 'padding: 5px 7px 5px 7px; text-align:center; font-size:15px; width:100%;']);
		echo '<div id="vertical" class="hovermenu ttmenu dark-style menu-color-gradient" style="margin: 0px 0px 0px 0px;">';
		echo '<div class="navbar navbar-default" role="navigation" style="margin: 0;">';
		echo '<div class="navbar-header">';
		echo '<button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button">';
		echo '<a class="navbar-brand" href="#">';
		echo '<i class="fa fa-bars">&nbsp;&nbsp;Категории: </i>';
		echo '</a>';
		echo '</div>';

		echo '<div id="v-menu" class="navbar-collapse collapse">';

		echo $this->tree($cat, $level);

		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		$this->registerJsLoc();
	}

	private function activeCategory()
	{
		$get = Yii::$app->request->get('cat');
		$session = Yii::$app->session;
		$session->open();
		$active_cat = $session->get('parent_cat');
		$session->close();

		if (!empty($active_cat)) {
			foreach ($active_cat as $item) {
				if ($item['lvl'] == 0) {
					$act_el = $item['alias'];
					break;
				} elseif ($item['rgt'] - $item['lft'] == 1) {
					$act_el = $item['alias'];
				}
			}
			return $act_el;
		} elseif (isset($get)) {
			return $get;
		} else {
			return false;
		}
	}

	private function tree($cat, $level)
	{
		$activ_el = $this->activeCategory();
		$path = Url::to('/goods/goods/index');
		echo '<ul class="nav navbar-nav">';
		foreach ($cat as $node) {
			if ($node['lvl'] == $level) {
				echo '</li>';
			} elseif ($node['lvl'] > $level) {
				if ($node['lvl'] == 1) {
					echo '<ul class="dropdown-menu vertical-menu">';
					echo '<li>';
				} elseif ($node['lvl'] == 2) {
					echo '<ul>';
				} else {
					echo '<ul>';
				}
			} else {
				echo '</li>';
				for ($i = $level - $node['lvl']; $i; $i--) {
					echo '</ul>';
					echo '</li>';
				}
			}
			if ($node['lvl'] == 0) {
				echo '<li class="dropdown">';
			} elseif ($node['lvl'] == 1) {
				echo '<li>';
			}
			if ($node['lvl'] == 0) {
				if ($node['alias'] == $activ_el) {
					echo Html::a($node['name'] . '<b class="dropme"></b>', [$path, 'cat' => $node['alias']], ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle active']);
				} else {
					echo Html::a($node['name'] . '<b class="dropme"></b>', [$path, 'cat' => $node['alias']], ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle']);
				}
			} elseif ($node['lvl'] == 1) {
				echo Html::a($node['name'], [$path, 'cat' => $node['alias']]);
			}
			$level = $node['lvl'];
		}
		for ($i = $level; $i; $i--) {
			//echo '</li>';
			if ($node['lvl'] == 1) {
				echo '</li>';
			}
			echo '</ul>';
		}
		echo '</ul>';
	}

	private function registerCssLoc()
	{
		$this->view->registerCssFile('/css/menu/menu.css', ['depends' => [\yii\web\YiiAsset::className()]]);
	}

	private function registerJsLoc()
	{
		$this->view->registerJsFile('/js/menu/ttmenu.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
		//$this->view->registerJsFile('/js/menu/jquery.fitvids.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
		$this->view->registerJsFile('/js/menu/hovernav.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
	}
}

?>