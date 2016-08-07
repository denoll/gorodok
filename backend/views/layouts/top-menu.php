<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.09.2015
 * Time: 1:17
 */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use \yii\helpers\Url;

$menuItems = [
	[
		'label'       => 'На сайт',
		'url'         => Url::to('@frt_url'),
		'linkOptions' => [
			'target' => '_blank',
		],
	],
	[
		'label' => 'Очистить кеш', 'items' => [
			[ 'label' => 'Общий кеш', 'url' => ['flush-cache', 'id'=>'cache'] ],
			[ 'label' => 'Фронтенд кеш', 'url' => ['flush-cache', 'id'=>'frontendCache'] ],
		],
	],

];
if ( Yii::$app->user->isGuest ) {
	$menuItems[] = [ 'label' => '<i class="fa fa-sign-in"></i> Вход ', 'url' => [ '/site/login' ] ];
} else {
	$menuItems[] = [
		'label'       => '<i class="fa fa-sign-out"></i> Выход (' . \Yii::$app->user->identity->username . ')',
		'url'         => [ '/site/logout' ],
		'linkOptions' => [ 'data-method' => 'post' ],
	];
}
?>

<div class="row border-bottom">
	<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
			<span><h1 style="display: inline-block; margin: 17px"><?= $this->title ?></h1></span>
		</div>
		<?= Nav::widget([
			'encodeLabels' => false,
			'options'      => [ 'class' => 'nav navbar-top-links navbar-right' ],
			'items'        => $menuItems,
		]); ?>
	</nav>
</div>
