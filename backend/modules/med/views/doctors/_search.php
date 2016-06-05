<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\med\BackDoctorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doctors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'id_spec') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'confirmed') ?>

    <?= $form->field($model, 'rank') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'exp') ?>

    <?php // echo $form->field($model, 'receiving') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'documents') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'm_keyword') ?>

    <?php // echo $form->field($model, 'm_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
