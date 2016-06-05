<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ForumThemeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-theme-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_cat') ?>

    <?= $form->field($model, 'id_author') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'to_top') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modify_at') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'm_keyword') ?>

    <?php // echo $form->field($model, 'm_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
