<?php
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var $payment Array ['invoice', 'pay_out', 'data', 'service', 'description', 'account'] */

$user = $current_user;

$link = $link; //Url::to('@frt_url/account/index');
?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($user->username) ?>.</h3>

	<p>Ваше объявление на сайте <?= Yii::$app->name ?> <strong>Удалено.</strong></p>
	<p>Номер объявления: <strong><?= $ads['id'] ?></strong></p>
	<p>Название объявления: <strong><?= $ads['name'] ?></strong></p>
	<p>Дата создания объявления: <strong><?= $ads['created_at'] ?></strong></p>
	<p>Дата удаления объявления: <strong><?= $date ?></strong></p>
	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
