<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use common\models\banners\BannerItem;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
	$model->click_count = 0;
	$model->max_click = 0;
}

?>

<div class="banner-item-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
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
			<?= $form->field($model, 'id_adv_company')->dropDownList(ArrayHelper::map($advert, 'id', 'name')) ?>

			<?= $form->field($model, 'id_user')->widget(Select2::classname(), [
				'language' => 'ru',
				'data' => ArrayHelper::map($users, 'id', 'username'),
				'options' => ['placeholder' => 'Веберите рекламодателя ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
			]); ?>

			<?= $form->field($model, 'banner_key')->dropDownList(ArrayHelper::map($blocks, 'key', 'key')) ?>

			<?= $form->field($model, 'size')->dropDownList(BannerItem::bannerSize()) ?>

			<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'status')->checkbox()->label('Активный') ?>

			<?= $form->field($model, 'order')->textInput() ?>

			<?= $form->field($model, 'click_count')->textInput() ?>

			<?= $form->field($model, 'max_click')->textInput() ?>

			<?= $form->field($model, 'start')->textInput() ?>

			<?= $form->field($model, 'stop')->textInput() ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'bannerImage')->widget(FileInput::classname(), [
				'options' => ['accept' => 'image/*'],
				'pluginOptions' => [
					'showPreview' => true,
					'initialPreview'=>[
						!empty($model->path) ? \Yii::$app->fileStorage->fileUrl('banners',$model->path) : false,
					],
					'initialPreviewAsData'=>true,
					'initialPreviewConfig' => [
						['caption' => $model->path],
					],
					'overwriteInitial'=>true,
				]
			]); ?>
			<br>

			<?php
			echo Yii::$app->fileStorage->hello();

			//echo BannerItem::bannerImgDir($model->path);
			if (!$model->isNewRecord && !empty($model->path)) {
				echo Html::img(\Yii::$app->fileStorage->fileUrl('banners',$model->path));
			}
			?>
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
	<?php ActiveForm::end(); ?>

</div>
