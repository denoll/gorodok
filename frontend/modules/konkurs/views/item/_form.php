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

if($model->isNewRecord){
	$konkurs = \common\models\konkurs\Konkurs::findOne(Yii::$app->session->get('id_konkurs'));
	$width = $konkurs->width;
	$height =$konkurs->height;
}else{
	$width = $model->konkurs->width;
	$height =$model->konkurs->height;
}

?>

	<div class="konkurs-item-form">

		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-md-12">
				<?= $form->field($model, 'image')->widget(
					'\denoll\filekit\widget\Upload',
					[
						'url' => ['upload'],
						'sortable' => false,
						'maxFileSize' => 10 * 1024 * 1024, // 10 MiB
						'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
					]
				); ?>
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'description')->textarea(['rows'=>6, 'maxlength' => true]) ?>
			</div>
		</div>
		<?= \common\widgets\buttons\ViewButtons::widget(['id' => $model->id]); ?>
		<?= $form->field($model, 'height')->hiddenInput(['value' => $height])->label(false) ?>
		<?= $form->field($model, 'width')->hiddenInput(['value' => $width])->label(false) ?>
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