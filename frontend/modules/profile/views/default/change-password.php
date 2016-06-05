<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use kartik\widgets\ActiveForm;


	/* @var $this yii\web\View */
	/* @var $form yii\bootstrap\ActiveForm */
	/* @var $model \common\models\LoginForm */

?>

	<div class="change-pass" <div class="container-fluid" style="padding: 25px 10px 25px 10px;">
	<div class="container-fluid">
		<button class="close" aria-label="Close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<header style="margin-bottom: 20px;">Изменение пароля</header>

		<?php $form = ActiveForm::begin(['id' => 'change-password', 'class' => '']); ?>

		<?= $form->field($user, 'old_password')->passwordInput()->label('Введите старый пароль') ?>

		<?= $form->field($user, 'password')->passwordInput()->label('Введите новый пароль (минимум 6 символов)') ?>

		<? //= $form->field($user, 'password_repeat')->passwordInput() ?>


		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right', 'name' => 'change-password-button']) ?>

		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php

	?>