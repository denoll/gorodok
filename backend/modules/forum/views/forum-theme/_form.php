<?php

	use common\models\users\User;
	use common\models\forum\ForumCat;
	use yii\helpers\Html;
	use kartik\form\ActiveForm;
	use vova07\imperavi\Widget as Imperavi;
	use kartik\widgets\SwitchInput;
	use kartik\date\DatePicker;
	use kartik\widgets\Select2;

	/* @var $this yii\web\View */
	/* @var $model common\models\ForumTheme */
	/* @var $form yii\widgets\ActiveForm */
	$status = \common\widgets\Arrays::forumThemeStatus();
?>

<div class="forum-theme-form">


	<div class="row">

		<?php $form = ActiveForm::begin(); ?>
		<div class="container-fluid">
			<div class="form-group">
				<div class="btn-group">
					<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
					<?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку тем', ['index'], ['class' => 'btn btn-default']) ?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="thumbnail" style="padding-left: 10px;">
				<?= $form->field($model, 'status')->radioList($status, [
					'inline' => false,
				]); ?>
			</div>

			<?= $form->field($model, 'order')->input('number', ['placeholder' => 'Настройте порядок...']) ?>

			<?= $form->field($model, 'to_top')->checkbox() ?>

			<?= $form->field($model, 'id_cat')->dropDownList(
				\yii\helpers\ArrayHelper::map(ForumCat::find()->all(), 'id', 'name')
			)->label('Категория')
			?>

			<div class="form-group">
				<label class="control-label">Теги для темы: </label>
				<?php
				$tags = \yii\helpers\ArrayHelper::map(\common\models\tags\Tags::find()->all(), 'name', 'name');
				$fm = \common\models\forum\ForumTheme::find()->with('tags')->where(['id' => $model->id])->all();
				foreach ($fm as $n) {
					// as string
					//$tagValues = $n->tagValues;
					// as array
					$tagValues = $n->getTagValues(true);
				}
				if ($tagNames != null || $tagNames != '') {
					$model->tagValues = $tagValues;
				}
				//echo $form->field($model, 'tagValues')->widget(Select2::classname(), [
				echo Select2::widget([
					'model' => $model,
					'attribute' => 'tagValues',
					'value' => $model->isNewRecord ? '' : $tagValues,
					'theme' => Select2::THEME_KRAJEE,
					'data' => $tags,
					'options' => [
						'placeholder' => 'Добавьте теги ...',
						'multiple' => true
					],
					'pluginOptions' => [
						'tags' => true,
						'tokenSeparators' => [',', ' '],
						'maximumInputLength' => 15,
						'allowClear' => true,
					],
				]);
				?>
				<br>

				<div class="container-fluid" style="margin-left:5px; padding: 5px; width: 100%;">
					<?php
					if (is_array($tagValues)) {
						foreach ($tagValues as $i => $tagName) {
							echo '<span class="tags">';
							echo $tagName;
							echo '</span>&nbsp;';
						}
					}
					?>
				</div>
			</div>

			<?= $form->field($model, 'id_author')->dropDownList(
				\yii\helpers\ArrayHelper::map(User::find()->all(), 'id', 'username')
			)->label('Автор')
			?>

			<?= $form->field($model, 'created_at')->widget(DatePicker::classname(), [
				'name' => 'dp_2',
				'type' => DatePicker::TYPE_COMPONENT_PREPEND,
				'value' => $model->isNewRecord ? '' : $model->created_at,
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'yyyy-mm-dd']])
			?>
			<?= $form->field($model, 'modify_at')->widget(DatePicker::classname(), [
				'name' => 'dp_2',
				'type' => DatePicker::TYPE_COMPONENT_PREPEND,
				'value' => $model->isNewRecord ? '' : $model->modify_at,
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'yyyy-mm-dd']])
			?>

		</div>
		<div class="col-md-9">


			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>


			<?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

			<?= $form->field($model, 'm_keyword')->textarea(['maxlength' => true]) ?>

			<?= $form->field($model, 'm_description')->textarea(['maxlength' => true]) ?>

		</div>
		<div class="container-fluid">
			<div class="form-group">
				<div class="btn-group">
					<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
					<?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку тем', ['index'], ['class' => 'btn btn-default']) ?>
				</div>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>

</div>