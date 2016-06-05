<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Здравствуйте <?= $user->username ?>,

Пожалуйста перейдите по ссылке для смены пароля:

<?= $resetLink ?>

   Если Вы не отправляли запрос на смену (восстановление) пароля, не переходите по этой ссылке, она автоматически деактивируется через 24 часа.
