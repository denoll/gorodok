<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\auto\AutoBrands;
use common\models\auto\AutoModels;

$get_model = Yii::$app->request->get('S');

if ( !empty($get_model[ 'id_brand' ]) ) {
	$auto_models = AutoModels::getModelsForOneBrand((int)$get_model[ 'id_brand' ]);
} else {
	$auto_models = [ ];
}

if ( !empty($get_model[ 'new' ]) ) {
	switch ( $get_model[ 'new' ] ) {
		case 0:
			$checked_0 = 'checked';
			$checked_1 = $checked_2 = null;
			break;
		case 1:
			$checked_1 = 'checked';
			$checked_0 = $checked_2 = null;
			break;
		case 2:
			$checked_2 = 'checked';
			$checked_0 = $checked_1 = null;
			break;
	}
} else {
	$checked_0 = 'checked';
	$checked_1 = $checked_2 = null;
}

/* @var $this yii\web\View */
/* @var $model common\models\med\DoctorsSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="realty-search">
	<?php $form = ActiveForm::begin([
		'method' => 'get',
	]); ?>

	<div class="filter">
		<div class="row">
			<div class=" container-fluid">
				<div class="radio_buttons">
					<div class="col-3">
						<input id="radio1" type="radio" <?= $checked_0 ?> value="0" name="S[new]">
						<label for="radio1">Все</label>
					</div>
					<div class="col-3">
						<input id="radio2" type="radio" <?= $checked_1 ?> value="1" name="S[new]">
						<label for="radio2">Только новые</label>
					</div>
					<div class="col-3">
						<input id="radio3" type="radio" <?= $checked_2 ?> value="2" name="S[new]">
						<label for="radio3">Только с пробегом</label>
					</div>
				</div>
				<div class="filter_element col-sm-4 side_left">
					<?= $form->field($model, 'id_brand')->dropDownList(ArrayHelper::map(AutoBrands::getAllBrands(), 'id', 'name'), [ 'id' => 'brand-id', 'onChange' => 'getModel()', 'prompt' => 'Выберите ...' ]); ?>
				</div>
				<div class="filter_element col-sm-4 side_left">
					<?= $form->field($model, 'id_model')->dropDownList(ArrayHelper::map($auto_models, 'id', 'name'), [ 'id' => 'model-id', 'prompt' => 'Выберите ...' ]) ?>
				</div>
				<div class="filter_element col-sm-4 side_left">
					<label class="control-label" for="el-cost">Стоимость (руб):</label>
					<table>
						<tr>
							<td><?= $form->field($model, 'price_min', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'от' ] ])->label(false) ?></td>
							<td><?= $form->field($model, 'price_max', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'до' ] ])->label(false) ?></td>
						</tr>
					</table>
				</div>
				<div class="filter_element col-sm-4 side_left">
					<?= $form->field($model, 'body', [ 'inputOptions' => [ 'class' => 'form-control' ] ])->dropDownList(\common\models\auto\Arrays::bodyAuto(), [ 'prompt' => '--' ]) ?>
				</div>
				<div class="filter_element col-sm-4 side_left">
					<?= $form->field($model, 'transmission', [ 'inputOptions' => [ 'class' => 'form-control' ] ])->dropDownList(\common\models\auto\Arrays::transmissionAuto(), [ 'prompt' => '--' ]) ?>
				</div>
				<div class="filter_element col-sm-4 side_left">
					<label class="control-label" for="el-distance">Год выпуска:</label>
					<table style="width: 100%;">
						<tr>
							<td style="width: 50%;"><?= $form->field($model, 'year_min', [ 'inputOptions' => [ 'class' => 'form-control' ] ])->dropDownList(\common\models\auto\Arrays::yearAuto(), [ 'prompt' => 'от --' ])->label(false) ?></td>
							<td style="width: 50%;"><?= $form->field($model, 'year_max', [ 'inputOptions' => [ 'class' => 'form-control' ] ])->dropDownList(\common\models\auto\Arrays::yearAuto(), [ 'prompt' => 'до --' ])->label(false) ?></td>
						</tr>
					</table>
				</div>
				<div class="filter_element col-sm-4 side_left" style="display: <?= $distance ?>">
					<label class="control-label" for="el-distance">Пробег (км):</label>
					<table>
						<tr>
							<td><?= $form->field($model, 'distance_min', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'от' ] ])->label(false) ?></td>
							<td><?= $form->field($model, 'distance_max', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'до' ] ])->label(false) ?></td>
						</tr>
					</table>
				</div>
				<div class="filter_element col-sm-4 side_left" style="display: <?= $distance ?>">
					<label class="control-label" for="el-distance">Объем двигателя (л):</label>
					<table>
						<tr>
							<td><?= $form->field($model, 'volume_min', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'от' ] ])->label(false) ?></td>
							<td><?= $form->field($model, 'volume_max', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'до' ] ])->label(false) ?></td>
						</tr>
					</table>
				</div>
				<div class="filter_element col-sm-4 side_left" style="display: <?= $area_home ?>">
					<label class="control-label" for="el-area">Мощность двигателя (л.с.):</label>
					<table>
						<tr>
							<td><?= $form->field($model, 'power_min', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'от' ] ])->label(false) ?></td>
							<td><?= $form->field($model, 'power_max', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'до' ] ])->label(false) ?></td>
						</tr>
					</table>
				</div>
				<div class="filter_element col-sm-4 side_left" style="display: <?= $area_land ?>">
					<?= $form->field($model, 'motor', [ 'inputOptions' => [ 'class' => 'form-control' ] ])->dropDownList(\common\models\auto\Arrays::motorAuto(), [ 'prompt' => '--' ]) ?>
				</div>
				<div class="filter_element col-sm-4 side_left" style="display: <?= $floor ?>">
					<?= $form->field($model, 'color', [ 'inputOptions' => [ 'class' => 'form-control' ] ])->dropDownList(\common\models\auto\Arrays::colorAuto(), [ 'prompt' => '--' ]) ?>
				</div>
				<div class="filter_element col-sm-4 side_left" style="display: <?= $floor_home ?>">
					<label class="control-label" for="el-area">&nbsp;</label>
					<span class="input-group-btn">
						<?= Html::submitButton('Найти', [ 'class' => 'btn-u ' ]) ?>
						<?= Html::a('<i class="fa fa-close"></i>', [ '/auto/item/index' ], [ 'class' => 'btn-u btn-brd' ]) ?>
					</span>
				</div>
			</div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>

<?php

$js = <<<JS
	function getModel() {
		var id_brand = $('#brand-id :selected').val();
	  $.ajax({
        type: "get",
        url: "/auto/item/get-model",
        data: "id_brand=" + id_brand,
        cache: true,
        dataType: "html",
        success: function (data) {
			$('#model-id').show();
			$('#model-id').html(data);
        }
    });
	}
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);

?>
