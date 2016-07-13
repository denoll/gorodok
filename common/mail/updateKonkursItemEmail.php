<?php
use yii\bootstrap\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var \common\models\konkurs\KOnkursItem $model */

$user = $current_user;

$link = $link; //Url::to('@frt_url/account/index');
?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($model->user->username) ?>.</h3>

	<p>На сайте <?= Yii::$app->name ?> созданный Вами элемент конкурса <strong> изменил свой статус.</strong></p>
	<p>Название конкурса: <strong><?= !empty($model->konkurs->title) ? $model->konkurs->title : $model->konkurs->name ?></strong></p>
	<p>Текущий статус загруженного Вами элемента конкурса: <strong><?= \common\models\konkurs\KonkursItem::getCurStatus($model->status) ?></strong></p>
	<p>Дата создания: <strong><?= $date ?></strong></p>
	<p><div style="display: block;"><?= Html::img($model->base_url.'/'.$model->img) ?></div></p>
	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
	<p>Текст: <strong><?= nl2br($model->description) ?></strong></p>
</div>
