<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\med\DoctorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctor-search">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<div class="filter">
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<div class="input-group">
				<?= $form->field($model, 'search_field', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...']])->label(false) ?>
				<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn-u']) ?></span>
			</div>
		</div>

		<div class="filter_element col-sm-6 side_left">
			<?= $form->field($model, 'cat')->widget(Select2::classname(), [
				'data' => \yii\helpers\ArrayHelper::map(Arrays::medSpec(), 'id', 'name'),
				'hideSearch' => false,
				'options' => ['placeholder' => 'Выбор по специализации'],
				'pluginOptions' => [
					'allowClear' => true
				],
			])->label('Специализация'); ?>
		</div>

		<div class="filter_element col-sm-6 side_left">
			<?= $form->field($model, 'receiving')->widget(Select2::classname(), [
				'data' => \yii\helpers\ArrayHelper::map(Arrays::reciving(), 'id', 'name'),
				'hideSearch' => true,
				'options' => ['placeholder' => 'выбор...'],
				'pluginOptions' => [
					'allowClear' => true
				],
			])->label('Ведет прием'); ?>
		</div>

		<div class="filter_element col-sm-3 side_left">
			<label class="control-label" for="el-salary">Стаж:</label>
			<table id="el-salary">
				<tr>
					<td><?= $form->field($model, 'exp_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
					<td><?= $form->field($model, 'exp_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
				</tr>
			</table>
		</div>
		<div class="filter_element col-sm-3 side_left">
			<label class="control-label" for="el-salary">Стоимость приема:</label>
			<table id="el-salary">
				<tr>
					<td><?= $form->field($model, 'price_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
					<td><?= $form->field($model, 'price_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
				</tr>
			</table>
		</div>

	</div>
	<?php ActiveForm::end(); ?>
</div>
