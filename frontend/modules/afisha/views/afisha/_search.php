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


?>

<div class="afisha-search">
	<?php $form = ActiveForm::begin([
		'action' => empty($get_cat) ? [ 'index' ] : [ 'index', 'cat' => $get_cat ],
		'method' => 'get',
	]); ?>

	<div class="filter">
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<div class="input-group">
				<?= $form->field($model, 'title', [ 'inputOptions' => [ 'class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...' ] ])->label(false) ?>
				<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', [ 'class' => 'btn-u' ]) ?></span>
			</div>
		</div>
		<div class="filter_element col-md-3 side_left" style="margin-top: 5px;">
			<?= $form->field($model, 'date_in')->widget(DatePicker::classname(), [
				'options'       => [ 'placeholder' => 'Дата начала ...' ],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'yyyy-m-d',
				],
			]);
			?>
		</div>
		<div class="filter_element col-md-3 side_left" style="margin-top: 5px;">
			<?= $form->field($model, 'date_out')->widget(DatePicker::classname(), [
				'options'       => [ 'placeholder' => 'Дата окончания ...' ],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'yyyy-m-d',
				],
			]);
			?>
		</div>

	</div>
	<?php ActiveForm::end(); ?>
</div>
