<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use common\models\banners\BannerItem;
use kartik\widgets\Select2;
use kartik\widgets\DateTimePicker;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
	$model->click_count = 0;
	$model->max_click = 0;
}

?>

<div class="banner-item-form">
	<button name="del-session" onclick="delSession()">Удалить сессию</button>
	<?php $form = ActiveForm::begin(); //['options' => ['enctype' => 'multipart/form-data']] ?>
	<div class="form-group">
		<?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<?= $form->errorSummary($model) ?>

	<div class="row">
		<div class="col-md-4">
			<?= $form->field($model, 'status')->dropDownList(\common\helpers\Arrays::statusBanner()) ?>
			<?= $form->field($model, 'id_adv_company')->dropDownList(ArrayHelper::map($advert, 'id', 'name'), ['onChange' => 'getSize()', 'prompt' => 'Выберите расположение баннера']) ?>
			<?= $form->field($model, 'id_user')->widget(Select2::classname(), [
				'language' => 'ru',
				'data' => ArrayHelper::map($users, 'id', 'username'),
				'options' => ['placeholder' => 'Веберите рекламодателя ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
			]); ?>
			<?= $form->field($model, 'banner_key')->dropDownList(ArrayHelper::map($blocks, 'key', 'name'), ['onChange' => 'getSize()', 'prompt' => 'Выберите расположение баннера']) ?>
			<?= $form->field($model, 'size')->dropDownList(BannerItem::bannerSize()) ?>
			<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'order')->textInput() ?>
			<?= $form->field($model, 'start')->widget(DateTimePicker::classname(), [
				'options' => ['placeholder' => 'Укажите дату и время ...'],
				'value' => date('Y-m-d H:i:s'),
				'pluginOptions' => [
					'autoclose' => true,
				]
			]); ?>
			<?= $form->field($model, 'stop')->widget(DateTimePicker::classname(), [
				'options' => ['placeholder' => 'Укажите дату и время ...'],
				'pluginOptions' => [
					'autoclose' => true
				]
			]); ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'files')->widget(
				'\denoll\filekit\widget\Upload',
				[
					'url' => ['upload'],
					'sortable' => false,
					'maxFileSize' => 2 * 1024 * 1024, // 1 MiB
					'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				]
			); ?>
			<?php
			if (!$model->isNewRecord && !empty($model->path)) {
				echo  $model->path;
			}
			?>
			<?= $form->field($model, 'day_count')->textInput() ?>
			<?= $form->field($model, 'max_day')->textInput() ?>
			<?= $form->field($model, 'click_count')->textInput() ?>
			<?= $form->field($model, 'max_click')->textInput() ?>
			<?= $form->field($model, 'hit_count')->textInput() ?>
			<?= $form->field($model, 'max_hit')->textInput() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="form-group">
		<?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<?= $form->field($model, 'height')->hiddenInput()->label(false) ?>
	<?= $form->field($model, 'width')->hiddenInput()->label(false) ?>
	<?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
	function getSize() {
		var banner_key = $('#banneritem-banner_key :selected').val();
	  $.ajax({
        type: "get",
        url: "get-size",
        data: "key=" + banner_key,
        cache: true,
        dataType: "json",
        success: function (data) {
			$('#banneritem-height').val(data.height);
           	$('#banneritem-width').val(data.width);
        }
    });
	}
JS;

$this->registerJs($js, \yii\web\View::POS_END);

?>
