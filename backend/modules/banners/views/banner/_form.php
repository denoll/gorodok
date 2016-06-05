<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\banners\Banner;

/* @var $this yii\web\View */
/* @var $model common\models\banners\Banner */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="widget-banner-form">
	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-12">
			<?php echo $form->field($model, 'key')->textInput(['maxlength' => 32]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'stage')->dropDownList(Banner::bannerStages()) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'col_size')->dropDownList(Banner::bannerColSize()) ?>
		</div>
		<div class="col-md-4">
			<?php echo $form->field($model, 'status')->checkbox() ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
