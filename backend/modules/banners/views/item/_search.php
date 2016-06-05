<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\banners\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_adv_company') ?>

    <?= $form->field($model, 'id_banner_user') ?>

    <?= $form->field($model, 'banner_key') ?>

    <?= $form->field($model, 'path') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'caption') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'click_count') ?>

    <?php // echo $form->field($model, 'max_click') ?>

    <?php // echo $form->field($model, 'start') ?>

    <?php // echo $form->field($model, 'stop') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
