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

	<p>На сайте <?= Yii::$app->name ?> созданный Вами рекламный баннер <strong> изменил свой статус.</strong></p>
	<p>Текущий статус баннера: <strong><?= \common\helpers\Arrays::getStatusBanner($model->status) ?></strong></p>
	<p>Номер баннера: <strong><?= $model->id ?></strong></p>
	<p>Изображение баннера: <div style="display: block;"><?= Html::img($model->base_url.'/'.$model->path) ?></div></p>
	<p>Дата изменеия статуса баннера: <strong><?= $date ?></strong></p>
	<p>Дата создания баннера: <strong><?= $model->created_at ?></strong></p>
	<p>Рекламная компания баннера: <strong><?= $model->advert->name ?></strong></p>
	<p>Место размещения баннера: <strong><?= $model->banner->name ?></strong></p>
	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
