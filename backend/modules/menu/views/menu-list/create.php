<?php

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;


	/* @var $this yii\web\View */
	/* @var $model app\modules\menu\models\MenuList */

	//$this->title = 'Create Menu List';
	//$this->params['breadcrumbs'][] = ['label' => 'Menu Lists', 'url' => ['index']];
	//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-list-create">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 style="margin:0px;"><?= Html::encode('Новое меню') ?></h4>
	</div>
	<div class="modal-body">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'status')->radioList(['1'=>'Активное','0'=>'Не активное']) ?>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>

</div>
