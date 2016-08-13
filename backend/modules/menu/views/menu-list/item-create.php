<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use common\models\Menu;

/* @var $model common\models\Menu */
/* @var $menuList common\models\MenuList */

	$items = \yii\helpers\ArrayHelper::map(Menu::find()->all(), 'id', 'title');
	array_unshift($items, 'Корневой пункт');
?>
<div class="menu-list-create">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
			<span class="sr-only">Close</span>
		</button>
		<h4 style="margin: 0px;"><?= Html::encode('Добавление нового пункта меню') ?></h4>
	</div>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<div class="modal-body">
			<div class="col-sm-6">
				<?= $form->field($model, 'status')->radioList(['1' => 'Активный', '0' => 'Не активный']) ?>
			</div>
			<div class="col-sm-6">
				<?= $form->field($model, 'parent')->dropDownList($items)->label('Родительский пункт меню') ?>
			</div>
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'meta_keyword')->textarea(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>
				</div>
			</div>
	</div>
	<div class="modal-footer">
		<div class="form-group">
			<?= $form->field($model, 'id_menu')->hiddenInput(['value' => $menuList->id])->label(false) ?>
			<?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
</div>
