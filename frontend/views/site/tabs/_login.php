<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 04.06.2016
 * Time: 12:45
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="panel panel-u">
	<div class="panel-heading">
		<h2 style="align-content: center; color: #fff;" class="panel-title">Для продолжения, войдите удобным вам способом</h2>
	</div>
	<div class="panel-body">
		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
		<div id="auth_block">
			<label class="auth-label" for="auth_block">Войдите через один из внешних сервисов.</label>
			<div class="service-block-auth">
				<?= yii\authclient\widgets\AuthChoice::widget([
					'baseAuthUrl' => ['site/auth'],
					'popupMode' => true,
				]) ?>
			</div>
			<label class="auth-label standart" for="auth_block">Или войдите стандартным способом.</label>
		</div>
		<?= $form->field($model_login, 'email') ?>

		<?= $form->field($model_login, 'password')->passwordInput()->label('Пароль') ?>

		<?= $form->field($model_login, 'rememberMe')->checkbox()->label('запомнить меня') ?>

		<div style="color:#999;margin:1em 0">
			Если Вы забыли свой пароль: <?= Html::a('нажмите здесь.', ['site/request-password-reset']) ?>.
		</div>

		<div class="form-group" style="margin: 0;">
			<?= Html::submitButton('Войти', ['class' => 'btn-u btn-block btn-u-dark', 'name' => 'action', 'value' => 'login']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>

