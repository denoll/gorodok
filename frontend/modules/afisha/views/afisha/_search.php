<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\med\DoctorsSearch */
/* @var $form yii\widgets\ActiveForm */

$get_cat = Yii::$app->request->get('cat');
$period = Yii::$app->request->get('period');
$d = 'btn-default';
$w = 'btn-default';
$t = 'btn-default';
$m = 'btn-default';
switch ( $period ) {
	case 'today':
		$d = 'btn-u';
		break;
	case 'tomorrow':
		$w = 'btn-u';
		break;
	case 'to-date':
		$t = 'btn-u';
		break;
}

?>

<div class="afisha-search">


	<div class="filter">
		<?php $form = ActiveForm::begin([
			'action' => empty($get_cat) ? [ 'index' ] : [ 'index', 'cat' => $get_cat ],
			'method' => 'get',
		]); ?>
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<div class="input-group">
				<?= $form->field($model, 'title', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...' ] ])->label(false) ?>
				<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', [ 'class' => 'btn-u' ]) ?></span>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<?php $form = ActiveForm::begin([
				'action' => empty($get_cat) ? [ 'index' ] : [ 'index', 'cat' => $get_cat ],
				'method' => 'get',
			]); ?>
			<table style="border-spacing: 0px 5px;">
				<tr>
					<td width="165px">
						Показать афишу:
					</td>
					<td width="180px">
						<?= Html::a('на сегодня', empty($get_cat) ? [ 'index', 'period' => 'today' ] : [ 'index', 'cat' => $get_cat, 'period' => 'today' ], [ 'class' => 'btn btn-block ' . $d ]) ?>
					</td>
					<td width="180px">
						<?= Html::a('на завтра', empty($get_cat) ? [ 'index', 'period' => 'tomorrow' ] : [ 'index', 'cat' => $get_cat, 'period' => 'tomorrow' ], [ 'class' => 'btn  btn-block ' . $w ]) ?>
					</td>
				</tr>
				<tr>
					<td width="165px">
						Показать на другую дату:
					</td>
					<td>
						<?php
						echo DatePicker::widget([
							'name'          => 'period',
							'options'       => [ 'placeholder' => 'Выберите дату ...' ],
							'removeButton'  => false,
							'pluginOptions' => [
								'autoclose' => true,
								'format'    => 'yyyy-mm-dd',
							],
						]);
						?>
					</td>
					<td>
						<?= Html::submitButton('Показать', [ 'class' => 'btn-u btn-block' ]) ?>
					</td>
				</tr>
			</table>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
