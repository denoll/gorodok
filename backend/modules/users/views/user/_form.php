<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\users\assets\UsersAsset;
use app\modules\users\helpers\CountryCodes;
use kartik\widgets\Select2;
use yii\web\View;
use yii\web\JsExpression;
UsersAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */

//$geo = Yii::$app->geoIp->getInfo($model->ip);
$country = CountryCodes::getFlags();

//	if($model->lat != '' || $model->lat != null){
//		$model->lat = $geo['latitude'];
//	}

?>
<?php
	$format = <<< SCRIPT
function format(state) {
//if (!state.id) return state.text; // optgroup
cod = state.id;
name = state.text;
return '<i class="flags flag-'+cod+'"></i> ' + name;
}
SCRIPT;
	$escape = new JsExpression("function(m) { return m; }");
	$this->registerJs($format, View::POS_HEAD);
?>
<div class="user-form row">
<div class="container-fluid">
    <?php $form = ActiveForm::begin(); ?>
	<div class="form-group">
		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
	</div>

	<div class="row" style="margin-bottom: 15px;">
		<div class="col-lg-6">
			<div class="ibox-content">
				<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'patronym')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox-content">
				<?= $form->field($model, 'status')->radioList(['10'=>'Активный пользователь', '0'=>'Заблокированный пользователь']) ?>

				<?= $form->field($model, 'password')->textInput(['maxlength' => true])->label('Пароль') ?>

				<?= $form->field($model, 'flags')->widget(Select2::classname(), [
					'data' =>  $country,
					'options' => ['placeholder' => 'Выберите страну ...'],
					'pluginOptions' => [
						'templateResult' => new JsExpression('format'),
						'templateSelection' => new JsExpression('format'),
						'escapeMarkup' => $escape,
						'allowClear' => true
					],
				]); ?>
				<?= $form->field($model, 'rating')->textInput() ?>

				<?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom: 15px;">
		<div class="col-lg-6">
			<div class="ibox-content">
				<?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'long')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
				<pre><?=$model->ip?></pre>
				<pre><?php //var_dump(Yii::$app->geoIp->ip); ?></pre>
				<pre><?php var_dump($geo);?></pre>

			</div>
		</div>
		<div class="col-md-6">
			<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
			<style type="text/css">
				html, body, #map {
					width: 100%;
					height: 500px;
					margin: 0;
					padding: 0;
				}
				#marker {
					width: 33px;
					height: 36px;
					position: absolute;
				}
			</style>
			<div class="ibox-content">
				<div id="map"></div>
				<div id="marker"></div>
			</div>
			<div class="ibox-content">
				<div id="geo_info"></div>
			</div>
		</div>
	</div>

    <div class="form-group">
	    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
<?php
	$this->registerJs('ymaps.ready(init);', View::POS_END);
?>