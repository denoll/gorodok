<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 18.03.2016
 * Time: 18:45
 */

namespace frontend\widgets;


use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class MainMenu
{
	public $activateParents = true;

	public static function init()
	{
		$logo = \yii\helpers\Html::img(\Yii::getAlias('@frontendUrl/img/whirlpool-logo-small.png'));
		$logoUrl = \Yii::$app->homeUrl;
		$logoOption = ['class' => 'navbar-brand'];
		$str = '';
		$str .= '<nav id="header" class="navbar navbar-default yamm navbar-light" role="navigation">';
		$str .= '<div class="container">';
		$str .= '<div class="navbar-header">';
		$str .= '<button class="navbar-toggle" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" type="button"><span class="sr-only">Toggle navigation</span><i class="fa fa-bars"></i></button>';
		$str .= Html::a($logo, $logoUrl, $logoOption);
		$str .= '</div>';
		$str .= '<div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse navbar-right">';
		$str .= '<ul class="nav navbar-nav">';
		$str .= self::firstLvl();
		$str .= '</ul>';
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</nav>';
		return $str;
	}

	public static function firstLvl()
	{
		$str = ' ';
		$items = self::items();
		if ($items['active']) {
			$active = 'active';
		}
		foreach ($items as $item) {
			if ($item['visible']) {
				if (empty($item['items'])) {
					$str .= '<li>';
					$str .= Html::a($item['label'], $item['url'], ['class' => $active]);
					$str .= '</li>';
				} else {
					if (!empty($item['items'][0]['items'])) {
						$linkOptions = ArrayHelper::merge($item['linkOptions'],['class' => 'dropdown-toggle ' . $active, 'data-hover' => 'dropdown', 'data-toggle' => 'dropdown']);
						$str .= '<li class="dropdown yamm-fw">';
						$str .= Html::a($item['label'], [$item['url'], $item['var'] => $item['cat']], $linkOptions);
						$str .= self::secondLvlYamm($item['items']);
					} else {
						$str .= '<li class="dropdown">';
						$linkOptions = ArrayHelper::merge($item['linkOptions'],['class' => 'dropdown-toggle ' . $active, 'data-hover' => 'dropdown', 'data-toggle' => 'dropdown']);
						$str .= Html::a($item['label'], [$item['url'], $item['var'] => $item['cat']], $linkOptions);
						$str .= self::secondLvl($item['items']);
					}
					$str .= '</li>';
				}
			}
		}
		return $str;
	}

	public static function secondLvl($items)
	{
		$str = '';
		$str .= '<ul class="dropdown-menu dropdown-menu-left animated-2x animated fadeIn">';
		foreach ($items as $item) {
			if ($item['visible']) {
				$linkOptions = ArrayHelper::merge($item['linkOptions'],['class' => 'megamenu-block-title']);
				$str .= '<li class="">';
				$str .= Html::a($item['label'], [$item['url'], $item['var'] => $item['cat']],$linkOptions);
				$str .= '</li>';
			}
		}
		$str .= '</ul>';
		return $str;

	}

	public static function secondLvlYamm($items)
	{
		$str = '';
		$str .= '<ul class="dropdown-menu dropdown-menu-right animated-2x animated fadeIn">';
		$str .= '<li class="dropdown-submenu">';
		$str .= '<div class="yamm-content">';
		$str .= '<div class="row">';
		foreach ($items as $item) {
			$linkOptions = ArrayHelper::merge($item['linkOptions'],['class' => 'megamenu-block-title']);
			if(count($items) <= 2){
				$str .= '<div class="col-lg-6 col-md-6 col-sm-6 col-megamenu">';
			}elseif(count($items) == 3){
				$str .= '<div class="col-lg-4 col-md-6 col-sm-6 col-megamenu">';
			}else{
				$str .= '<div class="col-lg-3 col-md-6 col-sm-6 col-megamenu">';
			}

			$str .= '<div class="megamenu-block">';
			$str .= Html::a($item['label'], [$item['url'], $item['var'] => $item['cat']], $linkOptions);
			if (!empty($item['items'])) {
				$str .= self::treeLvl($item['items']);
			}
			$str .= '</div>';
			$str .= '</div>';
		}
		$str .= '</div>';
		$str .= '</div>';
		$str .= '</li>';
		$str .= '</ul>';
		return $str;
	}

	public static function treeLvl($items)
	{
		$str = '';
		$str .= '<ul>';
		foreach ($items as $item) {
			if ($item['visible']) {
				$str .= '<li>';
				$str .= Html::a($item['label'], [$item['url'], $item['var'] => $item['cat']],$item['linkOptions']);
				$str .= '</li>';
			}
		}
		$str .= '</ul>';
		return $str;
	}

	public static function items()
	{
		return \common\models\MainMenu::getMenuTree();
	}

}