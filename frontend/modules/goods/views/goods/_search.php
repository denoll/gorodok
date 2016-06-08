<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\goods\GoodsSearch */
/* @var $form yii\widgets\ActiveForm */

$get_cat = Yii::$app->request->get('cat');
if (!empty($first_child)) {
	$data = \yii\helpers\ArrayHelper::map($first_child, 'alias', 'name');
} else {
	$data = false;
}
?>
<?php $form = ActiveForm::begin([
	'action' => empty($get_cat) ? ['index'] : ['index', 'cat' => $get_cat],
	'method' => 'get',
	'id' => 'search',
]); ?>
<style type="text/css">
	.help-block {
		margin: 0px !important;
	}

	.form-control {
		height: 35px;
	}
</style>
<div class="filter">
	<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
		<div class="input-group">
			<?= $form->field($model, 'search_field', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...']])->label(false) ?>
			<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn-u']) ?></span>
		</div>
	</div>
	<div class="filter_element col-sm-4 side_left">
		<label class="control-label" for="el-salary">Стоимость:</label>
		<table>
			<tr>
				<td><?= $form->field($model, 'cost_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
				<td><?= $form->field($model, 'cost_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
			</tr>
		</table>
	</div>
</div>
<?php ActiveForm::end(); ?>