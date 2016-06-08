<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\med\DoctorsSearch */
/* @var $form yii\widgets\ActiveForm */

$get_cat = Yii::$app->request->get('cat');
if (!empty($first_child)) {
	$data = \yii\helpers\ArrayHelper::map($first_child, 'alias', 'name');
} else {
	$data = false;
}
?>

<div class="news-search">
	<?php $form = ActiveForm::begin([
		'action' => empty($get_cat) ? ['index'] : ['index', 'cat' => $get_cat],
		'method' => 'get',
	]); ?>

	<div class="filter">
		<div class="filter_element col-md-12 side_left" style="margin-top: 5px;">
			<div class="input-group">
				<?= $form->field($model, 'title', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите искомую информацию или ее часть ...']])->label(false) ?>
				<span class="input-group-btn"><?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;&nbsp;Найти', ['class' => 'btn-u']) ?></span>
			</div>
		</div>
		<?php if ($data) { ?>
			<div class="filter_element col-sm-6 side_left">
				<?= $form->field($model, 'cat')->widget(Select2::classname(), [
					'data' => $data,
					'hideSearch' => false,
					'options' => ['placeholder' => 'Выбор подкатегории...'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Подкатегория'); ?>
			</div>
		<?php } ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
