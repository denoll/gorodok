<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursCat */
/* @var $form yii\widgets\ActiveForm */
$model->isNewRecord ? $model->status = 1 : '';

$categories = $model->find()->where(['status'=>1])->orderBy('order')->all();

?>

<div class="konkurs-cat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_parent')->dropDownList(\yii\helpers\ArrayHelper::map($categories, 'id', 'name'), ['prompt' => 'Выберите родительскую категорию...']) ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mk')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'md')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
