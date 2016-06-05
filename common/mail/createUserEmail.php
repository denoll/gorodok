<?php
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $current_user common\models\User */
/* @var $password string|null */

$user = $current_user;

$link = Url::to('@frt_url/account/index');
?>
<div class="payment">
	<h3>Здравствуйте, <?= Html::encode($user->username) ?>.</h3>

	<p>Вы успешно прошли регистрацию на сайте <strong><?= Yii::$app->name ?></strong></p>
	<h3>Ваши регистрационные данные:</h3>
	<p>Ваше имя: <strong><?= $user->username ?></strong></p>
	<p>Ваш Email: <strong><?= $user->email ?></strong></p>
	<?php if($password): ?>
	<p>Ваш пароль: <strong><?= $password ?></strong></p>
	<?php ENDIF ?>
	<p>Дата регистрации: <strong><?= $date ?></strong></p>
	<p>Для более подробной информации пройдите по ссылке: <?= Html::a($link, $link) ?></p>
</div>
