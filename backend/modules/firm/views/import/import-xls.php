<?php
	/**
	 * Created by PhpStorm.
	 * User: Администратор
	 * Date: 10.09.2015
	 * Time: 14:57
	 */

	use yii\widgets\ActiveForm;
	use \Yii;

?>
<div class="modal-info">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
	<div class="modal-header">
		<button class="close" aria-label="Close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<h4 class="modal-title">Загрузка файла Excel(*.xls) с фирмами </h4>
	</div>
	<div class="modal-body">
	<?= $form->field($model, 'file')->fileInput()->label('Выберите файл в формате Excel 97-2003(*.xls)') ?>
	</div>
	<div class="modal-footer">
		<button class="btn btn-outline" >Загрузить выбранный файл</button>
	</div>
	<?php ActiveForm::end() ?>

</div>