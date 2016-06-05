<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\Arrays;

?>


<div class="edu-add">
    <div class="container-fluid" style="padding: 25px 10px 25px 10px;">
        <div class="container-fluid">
            <button class="close" aria-label="Close" data-dismiss="modal" type="button">
                <span aria-hidden="true">×</span>
            </button>
            <header style="margin-bottom: 20px;"><?= $model->isNewRecord ? 'Добавление учебного заведения' : 'Изменение учебного заведения' ?></header>

            <?php $form = ActiveForm::begin(['id' => 'edu-add']); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'end_time')->dropDownList(Arrays::years(),['prompt'=>'Выберите год окончания ...']) ?>
            <?= $form->field($model, 'faculty')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'specialty')->textInput(['maxlength' => true]) ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right', 'name' => 'edu-add-btn']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
