<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use common\widgets\DbBanner;

$this->title = 'About';
$this->params[ 'breadcrumbs' ][] = $this->title;
$seo = Yii::$app->seo->getByKey('main_page');
$this->registerMetaTag([ 'content' => $seo->desc, 'name' => 'description' ]);
$this->registerMetaTag([ 'content' => $seo->kw, 'name' => 'keywords' ]);


?>
<div class="site-about">
	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Yii::$app->logo->getLogo() ?>
	</p>

	<div>
		<?= DbBanner::widget([ 'key' => 'banners_main_page_left' ]) ?>
	</div>


</div>
