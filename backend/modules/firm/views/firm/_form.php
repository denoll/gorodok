<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\firm\Firm */
/* @var $form yii\widgets\ActiveForm */
if ($model->isNewRecord) {
	$model->status = 1;
	$model->show_requisites = 0;
	$model->id_user = Yii::$app->user->id;
}
$categories = \yii\helpers\ArrayHelper::map(\common\models\firm\FirmCat::find()->where(['status' => 1])->orderBy('order')->all(), 'id', 'name');
$users = \yii\helpers\ArrayHelper::map(\common\models\users\User::find()->active()->andWhere(['company' => 1])->all(), 'id', 'username');

?>

<div class="firm-form">

	<?php $form = ActiveForm::begin([
		'options' => ['enctype' => 'multipart/form-data'],
	]); ?>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'id_cat')->dropDownList($categories, ['prompt' => 'Выберите категорию...']) ?>
			<?= $form->field($model, 'id_user')->dropDownList($users, ['prompt' => 'Выберите пользователя...']) ?>
			<?= $form->field($model, 'status')->checkbox() ?>
			<?= $form->field($model, 'show_requisites')->checkbox() ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">

			<?= $form->field($model, 'image')->widget(
				'\denoll\filekit\widget\Upload',
				[
					'url' => ['/firm/firm/upload'],
					'sortable' => false,
					'maxFileSize' => 2 * 1024 * 1024, // 1 MiB
					'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				]
			)->label('Логотип'); ?>
			<hr>
			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>
				</div>
				<div class="col-sm-6">
					<?= $form->field($model, 'lon')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
			<?= \common\widgets\yamaps\SetYaMap::widget([
				'lat' => $model->lat,
				'lon' => $model->lon,
				'firm_name' => $model->name,
				'address' => $model->address,
				'zoom' => 16,
			]); ?>
		</div>
	</div>

	<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'mk')->textarea(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'md')->textarea(['maxlength' => true]) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>
	<br><br><br>
</div>
