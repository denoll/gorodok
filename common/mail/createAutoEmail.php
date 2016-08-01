<?php
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var $ads \common\models\auto\AutoItem */
/* @var $link string */
/* @var $date string */

?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($current_user->username) ?>.</h3>

	<p>На сайте <?= Yii::$app->name ?> <strong> Вами создано новое объявление о продаже авто.</strong></p>
	<p>Номер объявления: <strong><?= $ads->id ?></strong></p>
	<p>Автомобиль: <strong><?= $ads->brand->name .'&nbsp;&nbsp;'. $ads->model->name . '&nbsp;-&nbsp;' .$ads->year . 'года выпуска.' ?></strong></p>
	<p>Стоимость: <strong><?= $ads->price ?>&nbsp;руб.</strong></p>
	<p>Дата создания объявления: <strong><?= $date ?></strong></p>
	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
