<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\users\BUserAccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_user') ?>

    <?= $form->field($model, 'pay_in') ?>

    <?= $form->field($model, 'pay_out') ?>

    <?= $form->field($model, 'pay_in_with_percent') ?>

    <?php // echo $form->field($model, 'invoice') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'service') ?>

    <?php // echo $form->field($model, 'yandexPaymentId') ?>

    <?php // echo $form->field($model, 'invoiceId') ?>

    <?php // echo $form->field($model, 'paymentType') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
