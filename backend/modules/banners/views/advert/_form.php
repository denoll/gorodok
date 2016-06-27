<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerAdv */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
	$model->status = 1;
	$model->hit_price = 0;
	$model->click_price = 0;
	$model->day_price = 0;
}
?>

<div class="banner-adv-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'status')->dropDownList(\common\models\banners\BannerAdv::advertStatuses()) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<div class="row">
		<div class="col-sm-3">
			<?= $form->field($model, 'hit_price')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'click_price')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'day_price')->textInput(['maxlength' => true]) ?>

		</div>
		<div class="col-sm-3">
			<?= $form->field($model, 'hit_size')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'click_size')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'day_size')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-sm-3">
			<div class="checkbox">
				<?= $form->field($model, 'hit_status')->checkbox() ?>
			</div>
			<div class="checkbox">
			<?= $form->field($model, 'click_status')->checkbox() ?>
			</div>
			<div class="checkbox">
				<?= $form->field($model, 'day_status')->checkbox() ?>
			</div>
		</div>

	</div>


	<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

	<div class="form-group">
		<?php echo Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
