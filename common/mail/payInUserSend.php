<?php
use yii\helpers\Html;
use \yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var $payment Array ['invoice', 'pay_in', 'date'] */

$user = $current_user;

$link = Url::to('@frt_url/account/index');
?>
<div class="payment">
    <h3>Здравствуйте, <?= Html::encode($user->username) ?>.</h3>

    <p>Вами был пополнен баланс на сайте <?= Yii::$app->name ?> на сумму <?= $payment['pay_in'] ?> рублей.</p>
    <p>Номер платежного документа: <?= $payment['invoice'] ?></p>

    <p>Для более подробной информации пройдите по ссылке: <?= Html::a($link,$link) ?></p>
</div>
