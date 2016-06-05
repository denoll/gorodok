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

	<p>На сайте <?= Yii::$app->name ?> <strong> Вами создано новое объявление.</strong></p>
	<p>Номер объявления: <strong><?= $ads['id'] ?></strong></p>
	<p>Название объявления: <strong><?= $ads['name'] ?></strong></p>
	<p>Дата создания объявления: <strong><?= $date ?></strong></p>
	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
