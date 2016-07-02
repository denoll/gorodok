<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\tree\TreeViewInput;
use kartik\widgets\Select2;
use bupy7\cropbox\Cropbox;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\goods\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form row" style="margin-bottom: 55px;">
	<div class="container-fluid">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<div class="row">
			<div class="col-md-3">
				<?= $form->field($model, 'id_cat')->widget(TreeViewInput::classname(), [
					'query' => \common\models\service\ServiceCat::find()->addOrderBy('root, lft'),
					'headingOptions' => ['label' => 'Укажите категорию'],
					//'name' => 'cat_list', //'Goods[id_cat]',    // input name
					'value' => true, //$model->isNewRecord ? '' : $model->id_cat,
					'rootOptions' => ['label' => '<span class="text-primary">Кореневая директория</span>'],
					'options' => [
						'placeholder' => 'выберите категорию ...',
						'disabled' => false
					],
					'fontAwesome' => true,     // optional
					'asDropdown' => true,            // will render the tree input widget as a dropdown.
					'multiple' => false,            // set to false if you do not need multiple selection
				])->label('Выберите категорию.'); ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'id_user')->widget(Select2::classname(), [
					'data' => \yii\helpers\ArrayHelper::map(Arrays::getAllUsers(), 'id', 'username'),
					'hideSearch' => false,
					'options' => ['placeholder' => 'Выбор пользователя...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Пользователь'); ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'status')->dropDownList(['1' => 'Опубликовано', '0' => 'Не опубликовано']) ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'buy')->dropDownList(['1' => 'Оказать', '0' => 'Получить']) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-3">
				<?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
			</div>
			<div class="col-sm-3">
				<?= $form->field($model, 'image')->widget(Cropbox::className(), [
					'attributeCropInfo' => 'crop_info',
					'optionsCropbox' => [
						'boxWidth' => Arrays::IMG_SIZE_WIDTH,
						'boxHeight' => Arrays::IMG_SIZE_HEIGHT,
						'cropSettings' => [
							[
								'width' => Arrays::IMG_SIZE_WIDTH,
								'height' => Arrays::IMG_SIZE_HEIGHT,
							],
						],
					],
					'previewUrl' => [
						Yii::getAlias('@frt_url/img/service/') . $model['main_img']
					],
				])->label($label); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6"><?= $form->field($model, 'm_keyword')->textarea(['maxlength' => true]) ?></div>
			<div class="col-md-6"><?= $form->field($model, 'm_description')->textarea(['maxlength' => true]) ?></div>
		</div>

		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
