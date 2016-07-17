<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\auto\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_model') ?>

    <?= $form->field($model, 'id_brand') ?>

    <?= $form->field($model, 'id_modify') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'vin') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'new') ?>

    <?php // echo $form->field($model, 'body') ?>

    <?php // echo $form->field($model, 'transmission') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'distance') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'customs') ?>

    <?php // echo $form->field($model, 'stage') ?>

    <?php // echo $form->field($model, 'crash') ?>

    <?php // echo $form->field($model, 'door') ?>

    <?php // echo $form->field($model, 'motor') ?>

    <?php // echo $form->field($model, 'privod') ?>

    <?php // echo $form->field($model, 'wheel') ?>

    <?php // echo $form->field($model, 'wheel_power') ?>

    <?php // echo $form->field($model, 'wheel_drive') ?>

    <?php // echo $form->field($model, 'wheel_leather') ?>

    <?php // echo $form->field($model, 'termal_glass') ?>

    <?php // echo $form->field($model, 'auto_cabin') ?>

    <?php // echo $form->field($model, 'sunroof') ?>

    <?php // echo $form->field($model, 'heat_front_seat') ?>

    <?php // echo $form->field($model, 'heat_rear_seat') ?>

    <?php // echo $form->field($model, 'heat_mirror') ?>

    <?php // echo $form->field($model, 'heat_rear_glass') ?>

    <?php // echo $form->field($model, 'heat_wheel') ?>

    <?php // echo $form->field($model, 'power_front_seat') ?>

    <?php // echo $form->field($model, 'power_rear_seat') ?>

    <?php // echo $form->field($model, 'power_mirror') ?>

    <?php // echo $form->field($model, 'power_wheel') ?>

    <?php // echo $form->field($model, 'folding_mirror') ?>

    <?php // echo $form->field($model, 'memory_front_seat') ?>

    <?php // echo $form->field($model, 'memory_rear_seat') ?>

    <?php // echo $form->field($model, 'memory_mirror') ?>

    <?php // echo $form->field($model, 'memory_wheel') ?>

    <?php // echo $form->field($model, 'auto_jockey') ?>

    <?php // echo $form->field($model, 'sensor_rain') ?>

    <?php // echo $form->field($model, 'sensor_light') ?>

    <?php // echo $form->field($model, 'partkronic_rear') ?>

    <?php // echo $form->field($model, 'parktronic_front') ?>

    <?php // echo $form->field($model, 'blind_spot_control') ?>

    <?php // echo $form->field($model, 'camera_rear') ?>

    <?php // echo $form->field($model, 'cruise_control') ?>

    <?php // echo $form->field($model, 'signaling') ?>

    <?php // echo $form->field($model, 'central_locking') ?>

    <?php // echo $form->field($model, 'immobiliser') ?>

    <?php // echo $form->field($model, 'satelite') ?>

    <?php // echo $form->field($model, 'airbags_front') ?>

    <?php // echo $form->field($model, 'airbags_knee') ?>

    <?php // echo $form->field($model, 'airbags_curtain') ?>

    <?php // echo $form->field($model, 'airbags_side_front') ?>

    <?php // echo $form->field($model, 'airbags_side_rear') ?>

    <?php // echo $form->field($model, 'abs') ?>

    <?php // echo $form->field($model, 'traction') ?>

    <?php // echo $form->field($model, 'rate_stability') ?>

    <?php // echo $form->field($model, 'brakeforce') ?>

    <?php // echo $form->field($model, 'emergency_braking') ?>

    <?php // echo $form->field($model, 'block_diff') ?>

    <?php // echo $form->field($model, 'pedestrian_detect') ?>

    <?php // echo $form->field($model, 'cd_system') ?>

    <?php // echo $form->field($model, 'mp3') ?>

    <?php // echo $form->field($model, 'radio') ?>

    <?php // echo $form->field($model, 'tv') ?>

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'wheel_manage') ?>

    <?php // echo $form->field($model, 'usb') ?>

    <?php // echo $form->field($model, 'aux') ?>

    <?php // echo $form->field($model, 'bluetooth') ?>

    <?php // echo $form->field($model, 'gps') ?>

    <?php // echo $form->field($model, 'audio_system') ?>

    <?php // echo $form->field($model, 'subwoofer') ?>

    <?php // echo $form->field($model, 'headlight') ?>

    <?php // echo $form->field($model, 'headlight_fog') ?>

    <?php // echo $form->field($model, 'headlight_washers') ?>

    <?php // echo $form->field($model, 'adaptive_light') ?>

    <?php // echo $form->field($model, 'bus') ?>

    <?php // echo $form->field($model, 'bus_winter_in') ?>

    <?php // echo $form->field($model, 'owners') ?>

    <?php // echo $form->field($model, 'service_book') ?>

    <?php // echo $form->field($model, 'dealer_serviced') ?>

    <?php // echo $form->field($model, 'garanty') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'mk') ?>

    <?php // echo $form->field($model, 'md') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
