<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use common\models\banners\BannerItem;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="banner-item-form">

	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->errorSummary($model) ?>

	<?= $form->field($model, 'id_adv_company')->dropDownList(ArrayHelper::map($advert, 'id', 'name')) ?>

	<?= $form->field($model, 'id_user')->dropDownList(ArrayHelper::map($users, 'id', 'username')) ?>

	<?= $form->field($model, 'banner_key')->dropDownList(ArrayHelper::map($blocks, 'key', 'key')) ?>

	<?= $form->field($model, 'bannerImage')->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>

	<?= $form->field($model, 'size')->dropDownList(BannerItem::bannerSize()) ?>

	<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->checkbox() ?>

	<?= $form->field($model, 'order')->textInput() ?>

	<?= $form->field($model, 'click_count')->textInput() ?>

	<?= $form->field($model, 'max_click')->textInput() ?>

	<?= $form->field($model, 'start')->textInput() ?>

	<?= $form->field($model, 'stop')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
