<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use kartik\widgets\SwitchInput;

$this->title = 'Регистрация';
?>
<div class="site-signup">

	<br>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
			<div class="panel panel-u">
				<div class="panel-heading">
					<h1 style="align-content: center; color: #fff;" id="how_signup" class="panel-title">Регистрация частного лица</h1>
				</div>
				<div class="panel-body">

					<?php $form = ActiveForm::begin([
						'id' => 'form-signup',
						'options' => [
							'class' => 'reg-page',
						]]); ?>
					<label class="control-label">Выберите как вы хотите зарегистрироваться:</label>
					<?= $form->field($model, 'company')->widget(SwitchInput::classname(), [
						'pluginOptions' => [
							'handleWidth' => 120,
							'onColor' => 'primary',
							'offColor' => 'primary',
							'labelText' => '<i id="lbl-text">как компания</i>',
							'onText' => 'как компания',
							'offText' => 'как частное лицо'
						],
						'pluginEvents' => [
							'switchChange.bootstrapSwitch' => 'function(element, options) {
                            if(options){
                                isCompany(1);
                            }else{
                                isCompany(0);
                            }
                        }',
						],
					])->label(false); ?>

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

					<?= $form->field($model, 'username') ?>
					<div id="s_name" style="display: none;">
						<?= $form->field($model, 'company_name') ?>
					</div>

					<?= $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'email', 'type' => 'email']])->label('Укажите email для связи.') ?>
					<?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'минимум 6 символов']])->passwordInput()->label('Пароль') ?>

					<hr class="no-margin" style="border-color: #ccc;">
					<?= $form->field($model, 'tel', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'в формате +79XXXXXX', 'type' => 'tel']])->label('Это не обязательное поле, но если Вы планируете подавать объявления, то рекомендуем указать номер телефона для связи с Вами.') ?>


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
						<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn-u btn-block btn-u-dark', 'name' => 'signup-button']) ?>
					</div>

					<?php ActiveForm::end(); ?>


				</div>
			</div>
			<div class="row tag-box tag-box-v5" style="margin-bottom: 30px;">
				<h5>Если уже зарегистрированы нажмите</h5>
				<?= Html::a('Войти', '/site/login', ['class' => 'btn-u btn-block btn-u-dark']) ?>
			</div>
		</div>
	</div>
</div>
<!--<script src='https://www.google.com/recaptcha/api.js?hl=<?= \common\widgets\captcha\Captcha::getLanguage() ?>'></script>-->
<?php
$this->registerCss('.form-group{margin-bottom: 0px;}');
$this->registerJsFile('/js/signup.js', ['depends' => [\yii\web\YiiAsset::className()]]);


?>
