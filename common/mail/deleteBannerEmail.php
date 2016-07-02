<?php
use yii\bootstrap\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var \common\models\banners\BannerItem $model */

$user = $current_user;

$link = $link; //Url::to('@frt_url/account/index');
?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($model->user->username) ?>.</h3>

	<p>На сайте <?= Yii::$app->name ?> <strong> был удален рекламный баннер.</strong></p>
	<p>Номер баннера: <strong><?= $model->id ?></strong></p>
	<p>Дата удаления баннера: <strong><?= $date ?></strong></p>
	<p>Рекламная компания баннера: <strong><?= $model->advert->name ?></strong></p>
	<p>Место размещения баннера: <strong><?= $model->banner->name ?></strong></p>
</div>
