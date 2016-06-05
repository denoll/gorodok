<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>

    <p>Пожалуйста перейдите по ссылке для смены пароля:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    <p>Если Вы не отправляли запрос на смену (восстановление) пароля, не переходите по этой ссылке, она автоматически деактивируется через 24 часа.</p>
</div>
