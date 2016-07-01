<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use app\widgets\DbText;

/* @var $this yii\web\View */
/* @var $model common\models\firm\Firm */
/* @var $form yii\widgets\ActiveForm */

$this->params['left'] = true;

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
		<div class="col-md-5">
			<?= $form->field($model, 'id_cat')->dropDownList($categories, ['prompt' => 'Выберите категорию...']) ?>
			<?= $form->field($model, 'show_requisites')->dropDownList(\common\helpers\Arrays::statusYesNo()) ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-7">
			<?= $form->field($model, 'image')->widget(
				'\denoll\filekit\widget\Upload',
				[
					'url' => ['/firm/firm/upload'],
					'sortable' => false,
					'maxFileSize' => 2 * 1024 * 1024, // 1 MiB
					'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				]
			)->label('Логотип'); ?>
			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
		</div>
		<div class="col-md-12">
			<div class="tag-box tag-box-v4 no-margin">
				<?= DbText::widget(['key' => 'add_address_with_yandex_map']) ?>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<?= $form->field($model, 'lat')->hiddenInput(['maxlength' => true])->label(false) ?>
				</div>
				<div class="col-sm-6">
					<?= $form->field($model, 'lon')->hiddenInput(['maxlength' => true])->label(false) ?>
				</div>
			</div>
			<?= $form->field($model, 'address')->hiddenInput(['maxlength' => true])->label(false) ?>
			<?= \common\widgets\yamaps\SetYaMap::widget([
				'lat' => $model->lat,
				'lon' => $model->lon,
				'firm_name' => $model->name,
				'address' => $model->address,
				'zoom' => 16,
			]); ?>
		</div>
	</div><br>
	<div class="form-group">
		<?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить данные о компании', ['class' => 'btn btn-block btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>
	<br><br><br>
</div>
