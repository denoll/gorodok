<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use kartik\widgets\RangeInput;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResumeSearch */
/* @var $form yii\widgets\ActiveForm */
?>



	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'id' => 'search',
	]); ?>
	<div class="filter">
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<div class="input-group">
				<?= $form->field($model, 'title', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...']])->label(false) ?>
				<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn-u']) ?></span>
			</div>
		</div>

		<div class="filter_element col-sm-6 side_left">
			<?= $form->field($model, 'cat')->widget(Select2::classname(), [
				'data' => \yii\helpers\ArrayHelper::map(Arrays::getJobCat(), 'id', 'name'),
				'hideSearch' => true,
				'options' => ['placeholder' => 'Сфера деятельности'],
				'pluginOptions' => [
					'allowClear' => true
				],
			])->label('Сфера деятельности'); ?>
		</div>

		<div class="filter_element col-sm-6 side_left">
			<?= $form->field($model, 'employment')->widget(Select2::classname(), [
				'data' => Arrays::employment(),
				'hideSearch' => true,
				'options' => ['placeholder' => 'График работы'],
				'pluginOptions' => [
					'allowClear' => true
				],
			])->label('График работы'); ?>
		</div>

		<div class="filter_element col-sm-3 side_left">
			<label class="control-label" for="el-salary">Зарплата:</label>
			<table id="el-salary">
				<tr>
					<td><?= $form->field($model, 'salary_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
					<td><?= $form->field($model, 'salary_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
				</tr>
			</table>
		</div>

		<div class="filter_element col-sm-3 side_left">
			<label class="control-label" for="el-age">Возраст:</label>
			<table id="el-age">
				<tr>
					<td><?= $form->field($model, 'age_min', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'от']])->label(false) ?></td>
					<td><?= $form->field($model, 'age_max', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'до']])->label(false) ?></td>
				</tr>
			</table>
		</div>
		<div class="filter_element col-sm-3 side_left">
			<?= $form->field($model, 'sex')->widget(Select2::classname(), [
				'data' => Arrays::sex(),
				'hideSearch' => true,
				'options' => ['placeholder' => 'Пол'],
				'pluginOptions' => [
					'allowClear' => true
				],
			]); ?>
		</div>
		<div class="filter_element col-sm-3 side_left">
			<?= $form->field($model, 'education')->widget(Select2::classname(), [
				'data' => Arrays::eduf(),
				'hideSearch' => true,
				'options' => ['placeholder' => 'Уровень обазования'],
				'pluginOptions' => [
					'allowClear' => true
				],
			]); ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>