<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bupy7\cropbox\Cropbox;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\slider\SliderMain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slider-main-form margin-bottom-60" style="display: block; content: ' '">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <?= $form->field($model, 'id_user')->widget(Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\common\widgets\Arrays::getAllUsers(), 'id', 'username'),
        'hideSearch' => false,
        'options' => ['placeholder' => 'Выбор пользователя...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Пользователь'); ?>
    <?= $form->field($model, 'image')->widget(Cropbox::className(), [
        'attributeCropInfo' => 'crop_info',
        'pluginOptions' => [
            'width' => 600,
            'height' => 400,
            'variants' => [
                [
                    'width' => 600,
                    'height' => 400,
                ],
            ],
        ],
        'previewImagesUrl' => [
            Yii::getAlias('@frt_url/img/slider/') . $model['thumbnail']
        ],
    ]); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
