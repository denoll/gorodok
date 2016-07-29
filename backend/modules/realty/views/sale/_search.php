<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\realty\models\SearchSale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realty-sale-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_cat') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'buy') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'area_home') ?>

    <?php // echo $form->field($model, 'area_land') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'floor_home') ?>

    <?php // echo $form->field($model, 'resell') ?>

    <?php // echo $form->field($model, 'in_city') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'repair') ?>

    <?php // echo $form->field($model, 'elec') ?>

    <?php // echo $form->field($model, 'gas') ?>

    <?php // echo $form->field($model, 'water') ?>

    <?php // echo $form->field($model, 'heating') ?>

    <?php // echo $form->field($model, 'tel_line') ?>

    <?php // echo $form->field($model, 'internet') ?>

    <?php // echo $form->field($model, 'distance') ?>

    <?php // echo $form->field($model, 'main_img') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'vip_date') ?>

    <?php // echo $form->field($model, 'adv_date') ?>

    <?php // echo $form->field($model, 'm_keyword') ?>

    <?php // echo $form->field($model, 'm_description') ?>

    <?php // echo $form->field($model, 'count_img') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
