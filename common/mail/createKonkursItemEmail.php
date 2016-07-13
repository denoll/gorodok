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

	<p><strong>Поздравляем, Вы приняли участие в конкурсе: <?= $model->konkurs->name?>, на сайте <?= \Yii::$app->name ?></strong></p>
	<p>Название конкурса: <strong><?= !empty($model->konkurs->title) ? $model->konkurs->title : $model->konkurs->name ?></strong></p>
	<p>Текущий статус загруженного Вами элемента конкурса: <strong><?= \common\models\konkurs\KonkursItem::getCurStatus($model->status) ?></strong></p>
	<div style="color: #0C257F; font-weight: 400; margin: 10px auto; border-bottom: 1px solid #980000; border-top: 1px solid #980000; padding: 10px;">
		<p>После того, как администрация сайта проверит присланные Вами данные (избражения и/или текст) данный элемент будет опубликован на сайте, и за него будет возможно голосовать.</p>
		<p>Об изменении статуса элемента конкурса, Вам придет Email.</p>
		<p>До публикации Вы сможете редактировать элемент по своему усмотрению.</p>
		<p>После проверки и публикации элемента конкурса на сайте, его редактирование будет не доступно.</p>
		<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
	</div>
	<p>Дата создания: <strong><?= $date ?></strong></p>
	<p><div style="display: block;"><?= Html::img($model->base_url.'/'.$model->img) ?></div></p>
	<hr>
	<p>Текст: <strong><?= nl2br($model->description) ?></strong></p>
</div>
