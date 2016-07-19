<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoModify */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auto-modify-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'version_id')->textInput() ?>

    <?= $form->field($model, 'y_from')->textInput() ?>

    <?= $form->field($model, 'y_to')->textInput() ?>

    <?= $form->field($model, 'item_type')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
