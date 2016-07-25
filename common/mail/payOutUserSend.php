<?php
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var $payment Array ['invoice', 'pay_out', 'data', 'service', 'description', 'account'] */

$user = $current_user;

$link = Url::to('@frt_url/account/index');
?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($user->username) ?>.</h3>

	<p>С Вашего счета на сайте <?= Yii::$app->name ?> были списаны средства на сумму <?= $payment['pay_out'] ?> рублей.</p>
	<p>Остаток средств на вашем счете: <?= $payment['account'] ?> рублей.</p>
	<p>Номер платежного документа: <?= $payment['invoice'] ?></p>

	<p>Услуга: <?= $payment['service'] ?></p>

	<p><?= $payment['description'] ?></p>

	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
