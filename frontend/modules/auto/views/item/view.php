<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\widgets\AdsSlider;
use \common\widgets\checks\ChecksWidget;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */

//$this->params[ 'left' ] = true;
$this->params[ 'right' ] = true;

$user = !Yii::$app->user->isGuest ? Yii::$app->user->getIdentity() : null;

$label = $model->attributeLabels();

$this->title = 'Объявление № ' . $model->id . '.  Авто ' . $model->brand->name . ' - ' . $model->model->name;
$this->params[ 'breadcrumbs' ][] = [ 'label' => 'Все объявления авто', 'url' => [ 'index' ] ];
$this->params[ 'breadcrumbs' ][] = $this->title;
$description = trim($model->description);
?>
<div class="auto-item-view">

	<div class="row">
		<div class="col-sm-12">
			<h1><strong style="font-size: 0.9em; font-style: italic;"><?= $model->brand->name . ' ' . $model->model->name . '  - ' . $model->year . ' года выпуска.' ?></strong></h1>
			<?php ?>
		</div>
		<div class="col-sm-7 side_left">
			<div class="thumbnail" style="padding: 2px;"><?= AdsSlider::runAuto($model->autoImg, '100%') ?></div>
		</div>
		<div class="col-sm-5">
			<?php if ( $user->id === $model->id_user ) { ?>
				<?= Html::a('<i class="fa fa-edit"></i>&nbsp;&nbsp;Редактировать это объявление', [ '/auto/item/update', 'id' => $model->id ], [ 'class' => 'btn btn-primary' ]) ?>
			<?php } ?>
			<?php if ( $model->user->company ) { ?>
				<h4 class="no-margin"><i class="small-text" style="font-size: 0.7em;">Продавец: </i><strong style="font-size: 0.9em; font-style: italic;"><?= $model->user->company_name ?></strong></h4>
				<h4 class="no-margin"><i class="small-text" style="font-size: 0.7em;">Контактное лицо: </i><strong style="font-size: 0.9em; font-style: italic;"><?= $model->user->username ?></strong></h4>
			<?php } else { ?>
				<h4><i class="small-text" style="font-size: 0.7em;">Продавец:</i><strong style="font-size: 0.9em; font-style: italic;"><?= $model->user->username ?></strong></h4>
			<?php } ?>
			<p style="margin: 2px;"><i class="small-text">Тел:</i> <strong><?= $model->user->tel == '' ? ' - не указан' : $model->user->tel ?></strong></p>

			<p style="margin: 2px;"><i class="small-text">E-mail:</i> <strong><?= $model->user->email ?></strong></p>
			<p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #555;"><i class="small-text">Цена: </i>&nbsp;<span
					style="font-weight: bold;"><?= $model[ 'price' ] != '' ? number_format($model[ 'price' ], 2, ',', "'") . '&nbsp;<i class="small-text">Руб. </i>' : ' - не указана' ?></span></p>
			<p>
				<span class="nowrap"><i class="small-text">Год выпуска:&nbsp;</i><strong><?= $model->year ?></strong>&nbsp;&nbsp;</span>
				<span class="nowrap"><i class="small-text">Пробег:&nbsp;</i><strong><?= number_format($model->distance, null, '', ' ') ?> км.</strong>&nbsp;&nbsp;</span>
				<br><span class="nowrap"><i class="small-text">Кузов:&nbsp;</i><strong><?= \common\models\auto\Arrays::getBodyAuto($model->body) ?></strong>&nbsp;&nbsp;</span>
				<span class="nowrap"><i class="small-text">Коробка передач:&nbsp;</i><strong><?= \common\models\auto\Arrays::getTransmissionAuto($model->transmission) ?></strong>&nbsp;&nbsp;</span>
				<span class="nowrap"><i class="small-text">Двигатель:&nbsp;</i><strong><?= \common\models\auto\Arrays::getMotorAuto($model->privod) ?></strong>&nbsp;&nbsp;</span>
				<span class="nowrap"><i class="small-text">Объем:&nbsp;</i><strong><?= $model->volume ?> л.</strong>&nbsp;&nbsp;</span>
				<br><span class="nowrap"><i class="small-text">Привод:&nbsp;</i><strong><?= \common\models\auto\Arrays::getPrivodAuto($model->privod) ?></strong>&nbsp;&nbsp;</span>
				<span class="nowrap"><i class="small-text">Мощность:&nbsp;</i><strong><?= $model->power ?> л.с.</strong>&nbsp;&nbsp;</span>
					<span class="nowrap"><i class="small-text">Цвет:&nbsp;</i>&nbsp;
						<span style="background-color: <?= $model->color; ?>;" class="color-bage">&nbsp;</span>&nbsp;
						<strong><?= \common\models\auto\Arrays::getColorAuto($model->color) ?></strong>&nbsp;&nbsp;
					</span>
				<br><span class="nowrap"><i class="small-text">Состояние:&nbsp;</i><strong><?= \common\models\auto\Arrays::getStageAuto($model->stage) ?></strong>&nbsp;&nbsp;</span>
				<br><span class="nowrap"><i class="small-text">VIN номер автомобиля:&nbsp;</i><strong><?= $model->vin ? $model->vin : ' не указан' ?></strong>&nbsp;&nbsp;</span>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<label>Описание: </label>
			<hr class="no-margin">
			<?= !empty($description) ? nl2br($description) : '' ; ?>
			<hr class="no-margin">
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 side_left">
			<?= ChecksWidget::widget([
				'field' => [
					[
						'type'  => 'string',
						'label' => $label[ 'owners' ],
						'val'   => $model->owners,
					],
					[
						'label' => $label[ 'service_book' ],
						'val'   => $model->service_book,
					],
					[
						'label' => $label[ 'garanty' ],
						'val'   => $model->garanty,
					],
					[
						'label' => $label[ 'dealer_serviced' ],
						'val'   => $model->dealer_serviced,
					],
					[
						'label' => $label[ 'customs' ],
						'val'   => $model->customs,
					],
					[
						'label' => $label[ 'crash' ],
						'val'   => $model->crash,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'field' => [
					[
						'type'  => 'string',
						'label' => $label[ 'wheel_power' ],
						'val'   => \common\models\auto\Arrays::getWheelPower($model->wheel_power),
					],
					[
						'type'  => 'string',
						'label' => $label[ 'climate_control' ],
						'val'   => \common\models\auto\Arrays::getClimateControl($model->climate_control),
					],
					[
						'label' => $label[ 'wheel_drive' ],
						'val'   => $model->wheel_drive,
					],
					[
						'label' => $label[ 'wheel_leather' ],
						'val'   => $model->wheel_leather,
					],
					[
						'label' => $label[ 'termal_glass' ],
						'val'   => $model->termal_glass,
					],
					[
						'type'  => 'string',
						'label' => $label[ 'auto_cabin' ],
						'val'   => \common\models\auto\Arrays::getCabinAuto($model->auto_cabin),
					],
					[
						'label' => $label[ 'sunroof' ],
						'val'   => $model->sunroof,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Обогрев:',
				'field' => [
					[
						'label' => $label[ 'heat_front_seat' ],
						'val'   => $model->heat_front_seat,
					],
					[
						'label' => $label[ 'heat_rear_seat' ],
						'val'   => $model->heat_rear_seat,
					],
					[
						'label' => $label[ 'heat_mirror' ],
						'val'   => $model->heat_mirror,
					],
					[
						'label' => $label[ 'heat_rear_glass' ],
						'val'   => $model->heat_rear_glass,
					],
					[
						'label' => $label[ 'heat_wheel' ],
						'val'   => $model->heat_wheel,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Электропривод:',
				'field' => [
					[
						'label' => $label[ 'power_front_seat' ],
						'val'   => $model->power_front_seat,
					],
					[
						'label' => $label[ 'power_rear_seat' ],
						'val'   => $model->power_rear_seat,
					],
					[
						'label' => $label[ 'power_mirror' ],
						'val'   => $model->power_mirror,
					],
					[
						'label' => $label[ 'power_wheel' ],
						'val'   => $model->power_wheel,
					],
					[
						'label' => $label[ 'folding_mirror' ],
						'val'   => $model->folding_mirror,
					],
				],
			]); ?>
		</div>
		<div class="col-md-4 side_left">
			<?= ChecksWidget::widget([
				'header' => 'Память настроек:',
				'field' => [
					[
						'label' => $label[ 'memory_front_seat' ],
						'val'   => $model->memory_front_seat,
					],
					[
						'label' => $label[ 'memory_rear_seat' ],
						'val'   => $model->memory_rear_seat,
					],
					[
						'label' => $label[ 'power_mirror' ],
						'val'   => $model->power_mirror,
					],
					[
						'label' => $label[ 'memory_mirror' ],
						'val'   => $model->memory_mirror,
					],
					[
						'label' => $label[ 'memory_wheel' ],
						'val'   => $model->memory_wheel,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Помощь при вождении:',
				'field' => [
					[
						'label' => $label[ 'auto_jockey' ],
						'val'   => $model->auto_jockey,
					],
					[
						'label' => $label[ 'sensor_rain' ],
						'val'   => $model->sensor_rain,
					],
					[
						'label' => $label[ 'sensor_light' ],
						'val'   => $model->sensor_light,
					],
					[
						'label' => $label[ 'partkronic_rear' ],
						'val'   => $model->partkronic_rear,
					],
					[
						'label' => $label[ 'parktronic_front' ],
						'val'   => $model->parktronic_front,
					],
					[
						'label' => $label[ 'blind_spot_control' ],
						'val'   => $model->blind_spot_control,
					],
					[
						'label' => $label[ 'camera_rear' ],
						'val'   => $model->camera_rear,
					],
					[
						'label' => $label[ 'cruise_control' ],
						'val'   => $model->cruise_control,
					],
					[
						'label' => $label[ 'signaling' ],
						'val'   => $model->signaling,
					],
					[
						'label' => $label[ 'computer' ],
						'val'   => $model->computer,
					],

				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Противоугонная система:',
				'field' => [
					[
						'label' => $label[ 'central_locking' ],
						'val'   => $model->central_locking,
					],
					[
						'label' => $label[ 'immobiliser' ],
						'val'   => $model->immobiliser,
					],
					[
						'label' => $label[ 'satelite' ],
						'val'   => $model->satelite,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Подушки безопасности:',
				'field' => [
					[
						'label' => $label[ 'airbags_front' ],
						'val'   => $model->airbags_front,
					],
					[
						'label' => $label[ 'airbags_knee' ],
						'val'   => $model->airbags_knee,
					],
					[
						'label' => $label[ 'airbags_curtain' ],
						'val'   => $model->airbags_curtain,
					],
					[
						'label' => $label[ 'airbags_side_front' ],
						'val'   => $model->airbags_side_front,
					],
					[
						'label' => $label[ 'airbags_side_rear' ],
						'val'   => $model->airbags_side_rear,
					],
				],
			]); ?>
		</div>
		<div class="col-md-4">
			<?= ChecksWidget::widget([
				'header' => 'Активная безопасность:',
				'field' => [
					[
						'label' => $label[ 'abs' ],
						'val'   => $model->abs,
					],
					[
						'label' => $label[ 'traction' ],
						'val'   => $model->traction,
					],
					[
						'label' => $label[ 'rate_stability' ],
						'val'   => $model->rate_stability,
					],
					[
						'label' => $label[ 'brakeforce' ],
						'val'   => $model->brakeforce,
					],
					[
						'label' => $label[ 'emergency_braking' ],
						'val'   => $model->emergency_braking,
					],
					[
						'label' => $label[ 'block_diff' ],
						'val'   => $model->block_diff,
					],
					[
						'label' => $label[ 'pedestrian_detect' ],
						'val'   => $model->pedestrian_detect,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Мультимедиа и навигация:',
				'field' => [
					[
						'type'  => 'string',
						'label' => $label[ 'audio_system' ],
						'val'   => \common\models\auto\Arrays::getAudioSystem($model->audio_system),
					],
					[
						'label' => $label[ 'cd_system' ],
						'val'   => $model->cd_system,
					],
					[
						'label' => $label[ 'mp3' ],
						'val'   => $model->mp3,
					],
					[
						'label' => $label[ 'radio' ],
						'val'   => $model->radio,
					],
					[
						'label' => $label[ 'tv' ],
						'val'   => $model->tv,
					],
					[
						'label' => $label[ 'video' ],
						'val'   => $model->video,
					],
					[
						'label' => $label[ 'wheel_manage' ],
						'val'   => $model->wheel_manage,
					],
					[
						'label' => $label[ 'usb' ],
						'val'   => $model->usb,
					],
					[
						'label' => $label[ 'aux' ],
						'val'   => $model->aux,
					],
					[
						'label' => $label[ 'bluetooth' ],
						'val'   => $model->bluetooth,
					],
					[
						'label' => $label[ 'gps' ],
						'val'   => $model->gps,
					],
					[
						'label' => $label[ 'subwoofer' ],
						'val'   => $model->subwoofer,
					],
				],
			]); ?>

			<hr class="no-margin">

			<?= ChecksWidget::widget([
				'header' => 'Фары:',
				'field' => [
					[
						'type'  => 'string',
						'label' => $label[ 'headlight' ],
						'val'   => \common\models\auto\Arrays::getHeadlightAuto($model->headlight),
					],
					[
						'label' => $label[ 'headlight_fog' ],
						'val'   => $model->headlight_fog,
					],
					[
						'label' => $label[ 'headlight_washers' ],
						'val'   => $model->headlight_washers,
					],
					[
						'label' => $label[ 'adaptive_light' ],
						'val'   => $model->adaptive_light,
					],
				],
			]); ?>
			<hr class="no-margin">
			<?= ChecksWidget::widget([
				'header' => 'Шины и диски:',
				'field' => [
					[
						'type'  => 'string',
						'label' => $label[ 'bus' ],
						'val'   => \common\models\auto\Arrays::getBusAuto($model->bus),
					],
					[
						'label' => $label[ 'bus_winter_in' ],
						'val'   => $model->bus_winter_in,
					],
				],
			]); ?>
		</div>
	</div>

</div>
