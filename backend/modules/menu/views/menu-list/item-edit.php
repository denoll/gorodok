<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\menu\models\Menu;

	$items = \yii\helpers\ArrayHelper::map(Menu::find()->all(), 'id', 'title');
	array_unshift($items, 'Корневой пункт');
?>
<div class="menu-list-update">
	<div class="ibox">
		<div class="ibox-title">
			<h4 style="margin: 0px;"><?= Html::encode('Изменение пункта меню: ' . ' ' . $model->title) ?></h4>
		</div>
		<div class="ibox-content">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
			<div class="col-md-6">
				<?= $form->field($model, 'status')->radioList(['1' => 'Активный', '0' => 'Не активный']) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'parent')->dropDownList($items)->label('Родительский пункт меню') ?>
			</div>
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
			<div class="row">
				<div class="col-md-6">
					<?= $form->field($model, 'm_keyword')->textarea(['maxlength' => true]) ?>
				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'm_description')->textarea(['maxlength' => true]) ?>
				</div>
			</div>
			<div class="form-group">
				<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
