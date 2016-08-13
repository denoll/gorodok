<?php

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	/* @var $this yii\web\View */
	/* @var $model app\modules\menu\models\MenuList */

	//$this->title = 'Update Menu List: ' . ' ' . $model->title;
	//$this->params['breadcrumbs'][] = ['label' => 'Menu Lists', 'url' => ['index']];
	//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
	//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-list-update">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 style="margin: 0px;"><?= Html::encode('Изменение меню: ' . ' ' . $model->title) ?></h4>
	</div>
	<?php $form = ActiveForm::begin(); ?>
	<div class="modal-body">

		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'status')->radioList(['1'=>'Активное','0'=>'Не активное']) ?>
		
		<?= $form->field($model, 'data')->textarea(['maxlength' => true]) ?>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>
