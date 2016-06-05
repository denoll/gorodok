<?php

	/* @var $this yii\web\View */
	/* @var $form yii\bootstrap\ActiveForm */
	/* @var $model \common\models\LoginForm */

	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;

	$this->title = 'Login';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" style="margin-top: 30%;">
	<h3>Вход в "Городок"</h3>

	<div class="row">
		<div class="col-lg-12">
			<div class="inbox-content">
				<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

				<?= $form->field($model, 'email')->label('Email') ?>

				<?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

				<?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

				<div class="form-group">
					<?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
				</div>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
