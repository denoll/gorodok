<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\banners\Banner;
use \common\models\banners\BannerAdv;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\banners\Banner */
/* @var $form yii\bootstrap\ActiveForm */

if(!$model->isNewRecord){
	$adv = $model->getAdvBlock();
	if($adv){
		$model->adv = ArrayHelper::getColumn($adv, 'id_adv') ;
	}
}
?>
<div class="widget-banner-form">
	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-12">
			<?php echo $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
			<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'stage')->dropDownList(Banner::bannerStages()) ?>
			<?php echo $form->field($model, 'status')->dropDownList(Banner::bannerStatuses()) ?>
		</div>
		<div class="col-md-4">
			<?= $form->field($model, 'adv')->dropDownList(ArrayHelper::map(BannerAdv::getAdvert(),'id' , 'name'),['multiple'=>true]) ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
