<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bupy7\cropbox\Cropbox;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\slider\SliderMain */
/* @var $form yii\widgets\ActiveForm */
/* @var $users \common\models\users\User */
$users = \common\widgets\Arrays::getAllUsers();
foreach ($users as $k => $user){
	$user_array[$k]['id'] = $user['id'];
	$user_array[$k]['name'] = $user['username'] . ' ' . $user['email'];;
}
?>

<div class="slider-main-form margin-bottom-60" style="display: block; content: ' '">

	<?php $form = ActiveForm::begin([
		'options' => [ 'enctype' => 'multipart/form-data' ],
	]); ?>
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ]) ?>
	</div>
	<?= $form->field($model, 'name')->textInput([ 'maxlength' => true ]) ?>
	<?= $form->field($model, 'status')->checkbox() ?>
	<?= $form->field($model, 'id_user')->widget(Select2::classname(), [
		'data'          => \yii\helpers\ArrayHelper::map($user_array, 'id', 'name'),
		'hideSearch'    => false,
		'options'       => [ 'placeholder' => 'Выбор пользователя...' ],
		'pluginOptions' => [
			'allowClear' => true,
		],
	])->label('Пользователь'); ?>
	<?= $form->field($model, 'image')->widget(Cropbox::className(), [
		'attributeCropInfo' => 'crop_info',
		'optionsCropbox'    => [
			'boxWidth'     => \common\models\slider\SliderMain::IMG_WIDTH,
			'boxHeight'    => \common\models\slider\SliderMain::IMG_HEIGHT,
			'cropSettings' => [
				[
					'width'  => \common\models\slider\SliderMain::IMG_WIDTH,
					'height' => \common\models\slider\SliderMain::IMG_HEIGHT,
				],
			],
		],
		'previewUrl'        => [
			Yii::getAlias('@frt_url/img/slider/') . $model[ 'thumbnail' ],
		],
	]); ?>

	<?= $form->field($model, 'description')->textInput([ 'maxlength' => true ]) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ]) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
