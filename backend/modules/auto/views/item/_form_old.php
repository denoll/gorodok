<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\auto\AutoModels;
use common\models\auto\AutoBrands;
use common\models\auto\AutoModify;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */
/* @var $form yii\widgets\ActiveForm */

if ($model->isNewRecord) {
	$model->status = 1;
	$disabled = true;
}

?>

<div class="auto-item-form">

	<?php $form = ActiveForm::begin(); ?>

	<?php
	// Parent
	echo $form->field($model, 'id_brand')->dropDownList(ArrayHelper::map(AutoBrands::getAllBrands(), 'id', 'name'), ['id'=>'brand-id', 'prompt'=>'Выберите марку автомобиля...']);

	// Child # 1
	echo $form->field($model, 'id_model')->widget(DepDrop::classname(), [
		'options'=>['id'=>'model-id'],
		'pluginOptions'=>[
			'depends'=>['brand-id'],
			'placeholder'=>'Выберите модель автомобиля...',
			'url'=>Url::to(['get-model'])
		]
	]);

	// Child # 2
	echo $form->field($model, 'id_modify')->widget(DepDrop::classname(), [
		'pluginOptions'=>[
			'options'=>['id'=>'modify-id'],
			'depends'=>['brand-id', 'model-id'],
			'placeholder'=>'Выберите модификацию автомобиля...',
			'url'=>Url::to(['get-modify'])
		]
	]);
	?>

	<?//= $form->field($model, 'id_brand')->dropDownList(ArrayHelper::map(AutoBrands::getAllBrands(), 'id', 'name'),['onChange' => 'getModel()', 'prompt'=>'Выберите марку автомобиля...']) ?>

	<?//= $form->field($model, 'id_model')->dropDownList(ArrayHelper::map(AutoModels::getAllModels(), 'id', 'name')), ['disabled' => 'disabled'] ?>

	<?= $form->field($model, 'id_modify')->textInput() ?>

	<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'body')->textInput() ?>

	<?= $form->field($model, 'transmission')->textInput() ?>

	<?= $form->field($model, 'year')->textInput() ?>

	<?= $form->field($model, 'distance')->textInput() ?>

	<?= $form->field($model, 'color')->textInput() ?>

	<?= $form->field($model, 'customs')->textInput() ?>

	<?= $form->field($model, 'stage')->textInput() ?>

	<?= $form->field($model, 'crash')->textInput() ?>

	<?= $form->field($model, 'vin')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->checkbox() ?>

	<?= $form->field($model, 'order')->textInput() ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'created_at')->textInput() ?>

	<?= $form->field($model, 'updated_at')->textInput() ?>

	<?= $form->field($model, 'mk')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'md')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<?php

$js = <<<JS
	function getModel() {
		var id_brand = $('#autoitem-id_brand :selected').val();
	  $.ajax({
        type: "get",
        url: "get-model",
        data: "id_brand=" + id_brand,
        cache: true,
        dataType: "html",
        success: function (data) {
			$('#autoitem-id_model').show();
			$('#autoitem-id_model').html(data);
        }
    });
	}
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);

?>
