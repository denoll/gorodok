<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auto Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_model',
            'id_brand',
            'id_modify',
            'status',
            'order',
            'vin',
            'price',
            'new',
            'body',
            'transmission',
            'year',
            'distance',
            'color',
            'customs',
            'stage',
            'crash',
            'door',
            'motor',
            'privod',
            'wheel',
            'wheel_power',
            'wheel_drive',
            'wheel_leather',
            'termal_glass',
            'auto_cabin',
            'sunroof',
            'heat_front_seat',
            'heat_rear_seat',
            'heat_mirror',
            'heat_rear_glass',
            'heat_wheel',
            'power_front_seat',
            'power_rear_seat',
            'power_mirror',
            'power_wheel',
            'folding_mirror',
            'memory_front_seat',
            'memory_rear_seat',
            'memory_mirror',
            'memory_wheel',
            'auto_jockey',
            'sensor_rain',
            'sensor_light',
            'partkronic_rear',
            'parktronic_front',
            'blind_spot_control',
            'camera_rear',
            'cruise_control',
            'signaling',
            'central_locking',
            'immobiliser',
            'satelite',
            'airbags_front',
            'airbags_knee',
            'airbags_curtain',
            'airbags_side_front',
            'airbags_side_rear',
            'abs',
            'traction',
            'rate_stability',
            'brakeforce',
            'emergency_braking',
            'block_diff',
            'pedestrian_detect',
            'cd_system',
            'mp3',
            'radio',
            'tv',
            'video',
            'wheel_manage',
            'usb',
            'aux',
            'bluetooth',
            'gps',
            'audio_system',
            'subwoofer',
            'headlight',
            'headlight_fog',
            'headlight_washers',
            'adaptive_light',
            'bus',
            'bus_winter_in',
            'owners',
            'service_book',
            'dealer_serviced',
            'garanty',
            'description',
            'created_at',
            'updated_at',
            'mk',
            'md',
        ],
    ]) ?>

</div>
