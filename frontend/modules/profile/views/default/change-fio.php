<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use kartik\widgets\ActiveForm;


?>

<div class="change-login" <div class="container-fluid" style="padding: 25px 10px 25px 10px;">
	<div class="container-fluid">
		<button class="close" aria-label="Close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<header style="margin-bottom: 20px;">Изменение ФИО</header>

		<?php $form = ActiveForm::begin(['id' => 'change-login', 'class' => '']); ?>

		<?= $form->field($user, 'name')->textInput()->label('<i>Введите имя</i>') ?>
		<?= $form->field($user, 'surname')->textInput()->label('<i>Введите фамилию</i>') ?>
		<?= $form->field($user, 'patronym')->textInput()->label('<i>Введите отчество</i>') ?>

		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right', 'name' => 'change-password-button']) ?>

		<?php ActiveForm::end(); ?>
	</div>
</div>
