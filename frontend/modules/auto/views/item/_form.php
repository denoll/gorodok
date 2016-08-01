<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\auto\AutoModels;
use common\models\auto\AutoBrands;
use common\models\auto\AutoModify;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */
/* @var $form yii\widgets\ActiveForm */

$this->params[ 'left' ] = true;
$this->params[ 'right' ] = true;

if ( $model->isNewRecord ) {
	$model->status = 1;
	$model->id_user = Yii::$app->user->id;
	$disabled = true;
	$auto_models = [ ];
} else {
	$auto_models = AutoModels::getModelsForOneBrand($model->id_brand);
}

?>

<div class="auto-item-form">

	<h1 class="header-title"><?= Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-3">
					<?= $form->field($model, 'new')->dropDownList(\common\models\auto\Arrays::newAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'id_brand')->dropDownList(ArrayHelper::map(AutoBrands::getAllBrands(), 'id', 'name'), [ 'id' => 'brand-id', 'onChange' => 'getModel()', 'prompt' => 'Выберите марку автомобиля...' ]); ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'id_model')->dropDownList(ArrayHelper::map($auto_models, 'id', 'name'), [ 'id' => 'model-id', 'prompt' => 'Выберите модель автомобиля...' ]) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'year')->dropDownList(\common\models\auto\Arrays::yearAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'price')->textInput([ 'maxlength' => true ]) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'volume')->textInput([ 'maxlength' => true ]) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'power')->textInput() ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'stage')->dropDownList(\common\models\auto\Arrays::stageAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'body')->dropDownList(\common\models\auto\Arrays::bodyAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'transmission')->dropDownList(\common\models\auto\Arrays::transmissionAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'color')->dropDownList(\common\models\auto\Arrays::colorAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'distance')->textInput() ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'motor')->dropDownList(\common\models\auto\Arrays::motorAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'door')->dropDownList(\common\models\auto\Arrays::doorsAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'privod')->dropDownList(\common\models\auto\Arrays::privodAuto()) ?>
				</div>
				<div class="col-sm-3">
					<?= $form->field($model, 'wheel')->dropDownList(\common\models\auto\Arrays::wheelAuto()) ?>
				</div>
			</div>
		</div>
	</div>
	<?= $form->field($model, 'vin')->textInput([ 'maxlength' => true ]) ?>
	<div id="accordion" class="panel-group acc-v1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="no-margin">
					<a class="accordion-toggle collapsed" href="#collapse" data-parent="#accordion" data-toggle="collapse" aria-expanded="false">Укажите дополнительные параметры и опции &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-bars"></i></a>
				</h4>
			</div>
			<div id="collapse" class="panel-collapse collapse" aria-expanded="false">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<?= $form->field($model, 'owners')->dropDownList(\common\models\auto\Arrays::ptsAuto(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'service_book')->checkbox() ?>

							<?= $form->field($model, 'dealer_serviced')->checkbox() ?>

							<?= $form->field($model, 'garanty')->checkbox() ?>

							<?= $form->field($model, 'customs')->checkbox() ?>

							<?= $form->field($model, 'crash')->checkbox() ?>

							<hr class="no-margin">

							<?= $form->field($model, 'wheel_power')->dropDownList(\common\models\auto\Arrays::wheelPower(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'climate_control')->dropDownList(\common\models\auto\Arrays::climateControl(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'wheel_drive')->checkbox() ?>

							<?= $form->field($model, 'termal_glass')->checkbox() ?>
							<hr class="no-margin">
							<?= $form->field($model, 'auto_cabin')->dropDownList(\common\models\auto\Arrays::cabinAuto(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'wheel_leather')->checkbox() ?>

							<?= $form->field($model, 'sunroof')->checkbox() ?>
							<hr class="no-margin">
							<h3>Обогрев:</h3>

							<?= $form->field($model, 'heat_front_seat')->checkbox() ?>

							<?= $form->field($model, 'heat_rear_seat')->checkbox() ?>

							<?= $form->field($model, 'heat_mirror')->checkbox() ?>

							<?= $form->field($model, 'heat_rear_glass')->checkbox() ?>

							<?= $form->field($model, 'heat_wheel')->checkbox() ?>
							<hr class="no-margin">
							<h3>Электропривод:</h3>
							<?= $form->field($model, 'power_front_seat')->checkbox() ?>

							<?= $form->field($model, 'power_rear_seat')->checkbox() ?>

							<?= $form->field($model, 'power_mirror')->checkbox() ?>

							<?= $form->field($model, 'power_wheel')->checkbox() ?>

							<?= $form->field($model, 'folding_mirror')->checkbox() ?>

						</div>
						<div class="col-md-4">
							<h3>Память настроек:</h3>
							<?= $form->field($model, 'memory_front_seat')->checkbox() ?>

							<?= $form->field($model, 'memory_rear_seat')->checkbox() ?>

							<?= $form->field($model, 'memory_mirror')->checkbox() ?>

							<?= $form->field($model, 'memory_wheel')->checkbox() ?>
							<hr class="no-margin">
							<h3>Помощь при вождении:</h3>
							<?= $form->field($model, 'auto_jockey')->checkbox() ?>

							<?= $form->field($model, 'sensor_rain')->checkbox() ?>

							<?= $form->field($model, 'sensor_light')->checkbox() ?>

							<?= $form->field($model, 'partkronic_rear')->checkbox() ?>

							<?= $form->field($model, 'parktronic_front')->checkbox() ?>

							<?= $form->field($model, 'blind_spot_control')->checkbox() ?>

							<?= $form->field($model, 'camera_rear')->checkbox() ?>

							<?= $form->field($model, 'cruise_control')->checkbox() ?>

							<?= $form->field($model, 'signaling')->checkbox() ?>

							<?= $form->field($model, 'computer')->checkbox() ?>
							<hr class="no-margin">
							<h3>Противоугонная система:</h3>
							<?= $form->field($model, 'central_locking')->checkbox() ?>

							<?= $form->field($model, 'immobiliser')->checkbox() ?>

							<?= $form->field($model, 'satelite')->checkbox() ?>
							<hr class="no-margin">
							<h3>Подушки безопасности:</h3>

							<?= $form->field($model, 'airbags_front')->checkbox() ?>

							<?= $form->field($model, 'airbags_knee')->checkbox() ?>

							<?= $form->field($model, 'airbags_curtain')->checkbox() ?>

							<?= $form->field($model, 'airbags_side_front')->checkbox() ?>

							<?= $form->field($model, 'airbags_side_rear')->checkbox() ?>
						</div>
						<div class="col-md-4">
							<h3>Активная безопасность:</h3>

							<?= $form->field($model, 'abs')->checkbox() ?>

							<?= $form->field($model, 'traction')->checkbox() ?>

							<?= $form->field($model, 'rate_stability')->checkbox() ?>

							<?= $form->field($model, 'brakeforce')->checkbox() ?>

							<?= $form->field($model, 'emergency_braking')->checkbox() ?>

							<?= $form->field($model, 'block_diff')->checkbox() ?>

							<?= $form->field($model, 'pedestrian_detect')->checkbox() ?>
							<hr class="no-margin">
							<h3>Мультимедиа и навигация:</h3>
							<?= $form->field($model, 'audio_system')->dropDownList(\common\models\auto\Arrays::audioSystem(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'cd_system')->checkbox() ?>

							<?= $form->field($model, 'mp3')->checkbox() ?>

							<?= $form->field($model, 'radio')->checkbox() ?>

							<?= $form->field($model, 'tv')->checkbox() ?>

							<?= $form->field($model, 'video')->checkbox() ?>

							<?= $form->field($model, 'wheel_manage')->checkbox() ?>

							<?= $form->field($model, 'usb')->checkbox() ?>

							<?= $form->field($model, 'aux')->checkbox() ?>

							<?= $form->field($model, 'bluetooth')->checkbox() ?>

							<?= $form->field($model, 'gps')->checkbox() ?>

							<?= $form->field($model, 'subwoofer')->checkbox() ?>

							<hr class="no-margin">

							<?= $form->field($model, 'headlight')->dropDownList(\common\models\auto\Arrays::headlightAuto(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'headlight_fog')->checkbox() ?>

							<?= $form->field($model, 'headlight_washers')->checkbox() ?>

							<?= $form->field($model, 'adaptive_light')->checkbox() ?>

							<hr class="no-margin">

							<?= $form->field($model, 'bus')->dropDownList(\common\models\auto\Arrays::busAuto(), [ 'prompt' => '--' ]) ?>

							<?= $form->field($model, 'bus_winter_in')->checkbox() ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr class="no-margin">
	<div class="row">
		<div class="col-sm-12">
			<?php echo $form->field($model, 'images')->widget(
				\denoll\filekit\widget\Upload::className(),
				[
					'url'              => [ '/auto/item/upload' ],
					'maxFileSize'      => 2000000, // 2 MiB
					'maxNumberOfFiles' => 10,
					'acceptFileTypes'  => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
				])->label('Добавьте фотографии автомобиля. Первая фотография будет использована как главный рисунок.');;
			?>
			<hr class="no-margin">
		</div>
		<div class="col-md-7">
			<?= $form->field($model, 'description')->textarea([ 'rows' => 8, 'maxlength' => true ]) ?>
		</div>
		<div class="col-md-5">
			<?php if ( $model->isNewRecord ) { ?>
				<?= $form->field($model, 'reCaptcha')->widget(
					\himiklab\yii2\recaptcha\ReCaptcha::className()
				) ?>
			<?php } ?>
		</div>
	</div>


	<div class="form-group">
		<?= \common\widgets\buttons\ViewButtons::widget([
			'close_url'  => '/auto/item/my-auto',
			'delete_url' => '/auto/item/delete', 'id' => $model->id,
		]); ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<?php

$js = <<<JS
	function getModel() {
		var id_brand = $('#brand-id :selected').val();
	  $.ajax({
        type: "get",
        url: "/auto/item/get-model",
        data: "id_brand=" + id_brand,
        cache: true,
        dataType: "html",
        success: function (data) {
			$('#model-id').show();
			$('#model-id').html(data);
        }
    });
	}
JS;

$this->registerJs($js, \yii\web\View::POS_BEGIN);

?>
