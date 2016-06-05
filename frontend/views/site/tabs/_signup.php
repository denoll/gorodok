<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 04.06.2016
 * Time: 12:44
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="panel panel-u">
	<div class="panel-heading">
		<h2 style="align-content: center; color: #fff;" id="how_signup" class="panel-title">Пройдите быструю регистрацию для продолжения</h2>
	</div>
	<div class="panel-body">

		<?php $form = ActiveForm::begin([
			'id' => 'form-signup',
			'options' => [
				'class' => 'reg-page',
			]]); ?>

		<div id="auth_block">
			<label class="auth-label" for="auth_block">Зарегестрируйтесь через один из внешних сервисов.</label>

			<div class="service-block-auth">
				<?= yii\authclient\widgets\AuthChoice::widget([
					'baseAuthUrl' => ['site/auth'],
					'popupMode' => true,
				]) ?>
			</div>
			<label class="auth-label standart" for="auth_block">Или пройдите регистрацию стандартным способом.</label>
		</div>

		<?= $form->field($model_signup, 'username') ?>
		<?= $form->field($model_signup, 'email', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'email', 'type' => 'email']])->label('Укажите email для связи.') ?>
		<?= $form->field($model_signup, 'password', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'минимум 6 символов']])->passwordInput()->label('Пароль') ?>

		<hr class="no-margin" style="border-color: #ccc;">
		<?= $form->field($model_signup, 'tel', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'в формате +79XXXXXX', 'type' => 'tel']])->label('Это не обязательное поле, но если Вы планируете подавать объявления, то рекомендуем указать номер телефона для связи с Вами.') ?>
		<?= $form->field($model_signup, 'company')->hiddenInput(['value'=>0])->label(false) ?>
		<div class="col-sm-12 no-side" style="display: block; content: ' ';">
			<i>Докажите что Вы не робот :-)</i>

			<div class="g-recaptcha" data-sitekey="<? //= \common\widgets\captcha\Captcha::getKey() ?>"></div>
			<br>
		</div>
		<div class="col-sm-12 no-side" style="padding: 3px;">
			<i class="small-text">Нажимая кнопку зарегистрироваться Вы даете
				свое <?= Html::a('согласие на использование персональных данных', ['/page/page/view', 'id' => 'soglasie-na-obrabotku-personalnyh-dannyh-polzovatelej'], ['target' => '_blank']) ?>. </i>
		</div>

		<div class="form-group">
			<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn-u btn-block btn-u-dark', 'name' => 'action', 'value' => 'signup']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>

