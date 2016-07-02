<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\med\DoctorsSearch */
/* @var $form yii\widgets\ActiveForm */

$get_cat = Yii::$app->request->get('cat');

$data = \yii\helpers\ArrayHelper::map(Arrays::getGoodsCat(), 'alias', 'name');
$status = [
	'1' => 'Опубликованные',
	'0' => 'Не опубликованные',
];

?>

<div class="widget lazur-bg style1 container-fluid">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<div class="filter">
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<div class="input-group" style="margin-top: 10px;">
				<?= $form->field($model, 'search_field', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите название товара, категорию или их часть ...']])->label(false) ?>
				<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn btn-primary']) ?></span>
			</div>
		</div>
		<?php if ($data) { ?>
			<div class="filter_element col-sm-6 side_left">
				<?= $form->field($model, 'cat')->widget(Select2::classname(), [
					'data' => $data,
					'hideSearch' => false,
					'options' => ['placeholder' => 'Выбор категории...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Категория'); ?>
			</div>
		<?php } ?>
		<div class="filter_element col-sm-3 side_left">
			<label class="control-label" for="el-salary">Стоимость:</label>
			<table id="el-salary">
				<tr>
					<td><?= $form->field($model, 'cost_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
					<td><?= $form->field($model, 'cost_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
				</tr>
			</table>
		</div>
		<div class="filter_element col-md-3 " style="margin-top: 5px;">
			<div class="input-group">

				<?= $form->field($model, 'status')->widget(Select2::classname(), [
					'data' => $status,
					'hideSearch' => true,
					'options' => ['placeholder' => 'Выбор статуса...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Подкатегория'); ?>
			</div>
		</div>
	</div>
	<?php $form = ActiveForm::end(); ?>
</div>
