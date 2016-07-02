<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\tree\TreeViewInput;
use yii\captcha\Captcha;
use yii\web\View;
use common\widgets\RealtyArrays;
use denoll\filekit\widget\Upload;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model common\models\goods\Goods */
/* @var $form yii\widgets\ActiveForm */
$this->params['left'] = true;
$label = \app\helpers\Texts::TEXT_CORRECT_IMAGE;

?>

<div class="goods-form row">
	<?php // Pjax::begin(); ?>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<div class="row container-fluid">
		<div class="col-sm-12">
			<?= $form->field($model, 'id_cat')->widget(TreeViewInput::classname(), [
				'query' => \common\models\realty\RealtyCat::find()->addOrderBy('root, lft'),
				'headingOptions' => ['label' => 'Укажите категорию'],
				'value' => true,
				'id' => 'id_category',
				'rootOptions' => ['label' => '<span class="text-primary">Кореневая директория</span>'],
				'options' => [
					'placeholder' => 'выберите категорию услуги...',
					'disabled' => false
				],
				'fontAwesome' => true,     // optional
				'asDropdown' => true,            // will render the tree input widget as a dropdown.
				'multiple' => false,            // set to false if you do not need multiple selection
			])->label('Выберите категорию (Выбирать можно только конечные категории помеченные синими иконками).'); ?>
			<div id="resell">
				<?= $form->field($model, 'resell')->checkbox(); ?>
			</div>
			<div id="in_city">
				<?= $form->field($model, 'in_city')->checkbox(); ?>
			</div>

			<div class="row" style="display: block; content: ' '">
				<?php $model->in_city ? $display = 'none' : $display = 'block'; ?>

				<div id="distance" class="col-sm-3" style="display: <?= $display ?>;">
					<?= $form->field($model, 'distance')->textInput(['maxlength' => true]); ?>
				</div>

				<div id="type" class="col-sm-3">
					<?= $form->field($model, 'type')->widget(Select2::classname(), [
						'data' => \yii\helpers\ArrayHelper::map(RealtyArrays::homeTypes(), 'id', 'name'),
						'hideSearch' => true,
						'options' => ['placeholder' => 'Выбрите ...'],
						'pluginOptions' => [
							'allowClear' => true
						],
					])->label('Тип строения'); ?>
				</div>
				<div id="repair" class="col-sm-3">
					<?= $form->field($model, 'repair')->widget(Select2::classname(), [
						'data' => \yii\helpers\ArrayHelper::map(RealtyArrays::realtyRepair(), 'id', 'name'),
						'hideSearch' => true,
						'options' => ['placeholder' => 'Выбрите ...'],
						'pluginOptions' => [
							'allowClear' => true
						],
					])->label('Состояние ремонта'); ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'cost')->textInput(['maxlength' => true])->label('Цена (руб).'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
		</div>
	</div>
	<div class="col-sm-6">

	</div>
	<div class="col-sm-6">

	</div>
	<hr style="margin: 0px 7px; border: none; border-bottom: 1px solid #fff; box-shadow: 0px 1px 0px rgba(0,0,0,0.04);">

	<div class="col-sm-12">
		<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Укажите заголовок объявления'); ?>
	</div>
	<div class="col-sm-12">
		<?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('Укажите адрес дома(строения)'); ?>
	</div>
	<div class="row">
		<div class="container-fluid">

		</div>
	</div>
	<div class="row">
		<div class="container-fluid">
			<div class="col-sm-3" id="area_home">
				<?= $form->field($model, 'area_home')->textInput(['maxlength' => true]); ?>
			</div>
			<div class="col-sm-3" id="area_land">
				<?= $form->field($model, 'area_land')->textInput(['maxlength' => true]); ?>
			</div>
			<div class="col-sm-3" id="floor">
				<?= $form->field($model, 'floor')->textInput(['maxlength' => true]); ?>
			</div>
			<div class="col-sm-3" id="floor_home">
				<?= $form->field($model, 'floor_home')->textInput(['maxlength' => true]); ?>
			</div>
		</div>
	</div>
	<label class="control-label" for="comfort" style="margin: 15px 2px 2px 5px;">Укажите имеющиеся удобства:</label>
	<hr style="margin: 0px 7px; border: none; border-bottom: 1px solid #ccc; box-shadow: 0px 1px 0px rgba(0,0,0,0.04);">
	<div id="comfort" class="row">
		<div class=" container-fluid">
			<div class="col-sm-2 side_left">
				<?= $form->field($model, 'elec')->widget(Select2::classname(), [
					'data' => ['1' => 'Есть', '0' => 'Нет'],
					'hideSearch' => true,
					'options' => ['placeholder' => 'Неважно'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Электричество'); ?>
			</div>
			<div class="col-sm-2 side_left">
				<?= $form->field($model, 'gas')->widget(Select2::classname(), [
					'data' => ['1' => 'Есть', '0' => 'Нет'],
					'hideSearch' => true,
					'options' => ['placeholder' => 'Неважно'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Газ'); ?>
			</div>
			<div class="col-sm-2 side_left">
				<?= $form->field($model, 'water')->widget(Select2::classname(), [
					'data' => ['1' => 'Есть', '0' => 'Нет'],
					'hideSearch' => true,
					'options' => ['placeholder' => 'Неважно'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Вода'); ?>
			</div>
			<div class="col-sm-2 side_left">
				<?= $form->field($model, 'heating')->widget(Select2::classname(), [
					'data' => ['1' => 'Есть', '0' => 'Нет'],
					'hideSearch' => true,
					'options' => ['placeholder' => 'Неважно'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Отопление'); ?>
			</div>
			<div class="col-sm-2 side_left">
				<?= $form->field($model, 'tel_line')->widget(Select2::classname(), [
					'data' => ['1' => 'Есть', '0' => 'Нет'],
					'hideSearch' => true,
					'options' => ['placeholder' => 'Неважно'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Телефон'); ?>
			</div>
			<div class="col-sm-2">
				<?= $form->field($model, 'internet')->widget(Select2::classname(), [
					'data' => ['1' => 'Есть', '0' => 'Нет'],
					'hideSearch' => true,
					'options' => ['placeholder' => 'Неважно'],
					'pluginOptions' => [
						'allowClear' => true
					],
				])->label('Интернет'); ?>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<?= $form->field($model, 'description')->textarea(['rows' => 6, 'maxlength' => true])->label('Описание объявления (макс. 1000 символов).'); ?>
	</div>
	<div class="col-sm-12">
		<?php echo $form->field($model, 'images')->widget(
			Upload::className(),
			[
				'url' => ['/realty/rent/upload'],
				'maxFileSize' => 2000000, // 2 MiB
				'maxNumberOfFiles' => 10,
				'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
			])->label('Добавьте фотографии объекта. Первая фотография будет использована как главный рисунок.');;
		?>
		<hr>
	</div>
	<div class="col-sm-12">
		<?php if ($model->isNewRecord) { ?>
			<?= $form->field($model, 'reCaptcha')->widget(
				\himiklab\yii2\recaptcha\ReCaptcha::className()
			) ?>
		<?php } ?>
		<div class="form-group">
			<?= Html::submitButton($model->isNewRecord ? 'Сохранить объявление' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			<?= Html::a('Вернуться ко всем моим объявлениям', ['my-ads'], ['class' => 'btn btn-default']) ?>
			<?php if (!$model->isNewRecord) {
				echo \yii\helpers\Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => [
					'confirm' => 'Вы действительно хотите удалить объявление?',
					'method' => 'post',
				],]);
			} ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>
	<?php // Pjax::end(); ?>
</div>

<?php
$css = <<< CSS
CSS;
$this->registerCss($css);
$id_cat = $model->isNewRecord ? 0 : $model->id_cat;
$this->registerJs('var id_category = ' . $id_cat . ';', View::POS_END);
$js = <<< JS
    $(document).ready(function(){
      changeElement(id_category);
    });


    $("#id_category").on('treeview.checked', function(event, key) {
        id_category = key;
        //console.log(key);
        changeElement(id_category);
    });

    $("#realtyrent-in_city").on("change",function(){
        if($("#realtyrent-in_city").prop("checked")){
                console.log("check");
            $('#distance').css("display","none");
        }else{
            console.log("uncheck");
            $('#distance').css("display","block");
        }
    });

    function changeElement(id_cat){
    $.ajax({
        type: "post",
        url: "change-element",
        data: "cat_id=" + id_cat,
        cache: true,
        dataType: "json",
        success: function (data) {
            if(data.area_home == 'show'){
                $('#area_home').css("display","block");
            }else if(data.area_home == 'hide') {
                $('#area_home').css("display","none");
            }
            if(data.area_land == 'show'){
                $('#area_land').css("display","block");
                $('#comfort').css("display","none");
            }else if(data.area_land == 'hide') {
                $('#area_land').css("display","none");
                $('#comfort').css("display","block");
            }
            if(data.comfort == 'show'){
                $('#comfort').css("display","block");
            }else if(data.area_land == 'hide') {
                $('#comfort').css("display","none");
            }
            if(data.repair == 'show'){
                $('#repair').css("display","block");
            }else if(data.repair == 'hide') {
                $('#repair').css("display","none");
            }
            if(data.resell == 'show'){
                $('#resell').css("display","block");
            }else if(data.resell == 'hide') {
                $('#resell').css("display","none");
            }
            if(data.type == 'show'){
                $('#type').css("display","block");
            }else if(data.type == 'hide') {
                $('#type').css("display","none");
            }
            if(data.floor == 'show'){
                $('#floor').css("display","block");
            }else if(data.floor == 'hide') {
                $('#floor').css("display","none");
            }
            if(data.floor_home == 'show'){
                $('#floor_home').css("display","block");
            }else if(data.floor_home == 'hide') {
                $('#floor_home').css("display","none");
            }
        }
    });
}

JS;
$this->registerJs($js, View::POS_END);
//$this->registerJsFile('/js/ajax/realty-rent.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>
