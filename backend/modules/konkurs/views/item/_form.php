<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */
/* @var $users common\models\users\User */
/* @var $form yii\widgets\ActiveForm */
?>

	<div class="konkurs-item-form">

		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-md-8">
				<?= $form->field($model, 'id_konkurs')->dropDownList(ArrayHelper::map(\common\models\konkurs\KonkursItem::allKonkurs(),'id','name'), ['onChange' => 'getSize()', 'prompt' => 'Выберите конкурс ...']) ?>
				<?= $form->field($model, 'id_user')->widget(Select2::classname(), [
					'language' => 'ru',
					'data' => ArrayHelper::map($users, 'id', 'username'),
					'options' => ['placeholder' => 'Веберите пользователя ...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				]); ?>
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'description')->textarea(['rows'=>6, 'maxlength' => true]) ?>
				<div class="row">
					<div class="col-sm-6">
						<?= $form->field($model, 'created_at')->widget(DateTimePicker::classname(), [
							'options' => ['placeholder' => 'Укажите дату и время ...'],
							'value' => date('Y-m-d H:i:s'),
							'pluginOptions' => [
								'autoclose' => true,
							]
						]); ?>
					</div>
					<div class="col-sm-6">
						<?= $form->field($model, 'updated_at')->widget(DateTimePicker::classname(), [
							'options' => ['placeholder' => 'Укажите дату и время ...'],
							'pluginOptions' => [
								'autoclose' => true
							]
						]); ?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<?= $form->field($model, 'status')->dropDownList(\common\models\konkurs\KonkursItem::getStatuses()) ?>
				<?= $form->field($model, 'image')->widget(
					'\denoll\filekit\widget\Upload',
					[
						'url' => ['upload'],
						'sortable' => false,
						'maxFileSize' => 10 * 1024 * 1024, // 10 MiB
						'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
					]
				); ?>
				<?php
				if (!$model->isNewRecord && !empty($model->path)) {
					echo  $model->path;
				}
				?>
				<?//= $form->field($model, 'yes')->textInput() ?>

				<?//= $form->field($model, 'no')->textInput() ?>

				<?= $form->field($model, 'scope')->textInput() ?>
			</div>
		</div>
		<?= \common\widgets\buttons\ViewButtons::widget(['id' => $model->id]); ?>
		<?= $form->field($model, 'height')->hiddenInput()->label(false) ?>
		<?= $form->field($model, 'width')->hiddenInput()->label(false) ?>
		<?php ActiveForm::end(); ?>

	</div>
<?php
$js = <<<JS
	function getSize() {
		var id = $('#konkursitem-id_konkurs :selected').val();
	  $.ajax({
        type: "get",
        url: "get-size",
        data: "id=" + id,
        cache: true,
        dataType: "json",
        success: function (data) {
			$('#konkursitem-height').val(data.height);
           	$('#konkursitem-width').val(data.width);
        }
    });
	}
JS;

$this->registerJs($js, \yii\web\View::POS_END);

?>