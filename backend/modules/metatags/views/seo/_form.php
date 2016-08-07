<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Metatags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metatags-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kw')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= \common\widgets\buttons\ViewButtons::widget(['id' => $model->key]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
