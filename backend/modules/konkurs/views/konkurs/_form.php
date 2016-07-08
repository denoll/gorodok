<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\Arrays;
use yii\web\JsExpression;
use mihaildev\ckeditor\CKEditor;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="konkurs-form">

	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-8">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'start')->widget(DatePicker::classname(), [
						'name' => 'dp_2',
						'type' => DatePicker::TYPE_COMPONENT_PREPEND,
						'value' => $model->isNewRecord ? '' : $model->start,
						'pluginOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd']])
					?>
				</div>
				<div class="col-sm-6">
					<?= $form->field($model, 'stop')->widget(DatePicker::classname(), [
						'name' => 'dp_2',
						'type' => DatePicker::TYPE_COMPONENT_PREPEND,
						'value' => $model->isNewRecord ? '' : $model->stop,
						'pluginOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd']])
					?>
				</div>
			</div>
			<?= $form->field($model, 'description')->widget(CKEditor::className(),[
				'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions(['elfinder', 'path' => 'konkurs/editor'], [
					'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
					'inline' => false, //по умолчанию false
				]),
			]); ?>
			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'mk')->textarea(['maxlength' => true]) ?>
				</div>
				<div class="col-sm-6">
					<?= $form->field($model, 'md')->textarea(['maxlength' => true]) ?>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'status')->dropDownList(Arrays::status()) ?>
			<?= $form->field($model, 'show_img')->dropDownList(Arrays::statusYesNo()) ?>
			<?= $form->field($model, 'show_des')->dropDownList(Arrays::statusYesNo()) ?>
			<?= $form->field($model, 'stars')->dropDownList(Arrays::typeKonkurs()) ?>
			<?= $form->field($model, 'image')->widget(
				'\denoll\filekit\widget\Upload',
				[
					'url' => ['upload'],
					'sortable' => false,
					'maxFileSize' => 20 * 1024 * 1024, // 20 MiB
					'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				]
			); ?>
			<?php
			if (!$model->isNewRecord && !empty($model->path)) {
				echo  $model->path;
			}
			?>
			<hr>
			<label>Размеры изображений элементов конкурса</label>
			<?= $form->field($model, 'width')->textInput() ?>
			<?= $form->field($model, 'height')->textInput() ?>
		</div>
	</div>

	<?= \common\widgets\buttons\ViewButtons::widget(['id' => $model->id]); ?>

	<?php ActiveForm::end(); ?>

</div>

