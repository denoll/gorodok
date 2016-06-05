<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\LettersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="letters-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_cat') ?>

    <?= $form->field($model, 'id_tags') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'unpublish') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'subtitle') ?>

    <?php // echo $form->field($model, 'short_text') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'm_keyword') ?>

    <?php // echo $form->field($model, 'm_description') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'thumbnail') ?>

    <?php // echo $form->field($model, 'images') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
