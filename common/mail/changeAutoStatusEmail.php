<?php
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var $ads \common\models\auto\AutoItem */

$user = $current_user;

$link = $link; //Url::to('@frt_url/account/index');
?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($user->username) ?>.</h3>

	<p>Статус вашего объявления на сайте <?= Yii::$app->name ?> изменен.</p>
	<p>Номер объявления: <strong><?= $ads->id ?></strong></p>
	<p>Объявление: <strong><?= $ads->brand->name . ' - ' . $ads->model->name ?></strong></p>
	<p>Дата создания объявления: <strong><?= $ads['created_at'] ?></strong></p>
	<p>Новый статус объявления: <strong><?= \common\models\auto\Arrays::getStatusAuto($ads->status) ?></strong></p>

	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
