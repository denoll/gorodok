<?php

	use yii\helpers\Html;
	use kartik\form\ActiveForm;
	use vova07\imperavi\Widget as Imperavi;
	use kartik\widgets\Select2;
	use kartik\widgets\SwitchInput;
	use kartik\date\DatePicker;

	/* @var $this yii\web\View */
	/* @var $model common\models\Forums */
	/* @var $form yii\widgets\ActiveForm */
	$status = ['0' => 'Закрыт', '1' => 'Активный'];
?>

<div class="forums-form">

	<div class="row">

		<?php $form = ActiveForm::begin(); ?>
		<div class="container-fluid">
			<div class="form-group">
				<div class="btn-group">
					<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
					<?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку форумов', ['index'], ['class' => 'btn btn-default']) ?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="thumbnail" style="padding-left: 10px;">
			<?= $form->field($model, 'status')->radioList($status, [
				'inline'=>false,
			]); ?>
			</div>
			<?= $form->field($model, 'on_main')->widget(SwitchInput::className(), [
				'name' => 'activation_main',
				'pluginOptions' => [
					//'size' => 'large'
					'state' => $model->isNewRecord ? 1 : $model->on_main,
					'onText' => 'Показать',
					'offText' => 'Скрыть',
					'onColor' => 'success',
					'offColor' => 'danger',
				]
			]) ?>
			<?//= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'order')->input('number', ['placeholder' => 'Введите цифру порядка расположения ...']) ?>


		</div>
		<div class="col-md-9">

			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>


			<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

			<?= $form->field($model, 'm_keywords')->textarea(['maxlength' => true]) ?>

			<?= $form->field($model, 'm_description')->textarea(['maxlength' => true]) ?>

		</div>
		<div class="container-fluid">
			<div class="form-group">
				<div class="btn-group">
					<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
					<?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку форумов', ['index'], ['class' => 'btn btn-default']) ?>
				</div>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>

</div>
