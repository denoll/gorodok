<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\Arrays;
use denoll\editor\CKEditor as CKEditor;
?>


<div class="edu-add">
    <div class="container-fluid" style="padding: 25px 10px 25px 10px;">
        <div class="container-fluid">
            <button class="close" aria-label="Close" data-dismiss="modal" type="button">
                <span aria-hidden="true">×</span>
            </button>
            <header style="margin-bottom: 20px;"><?= $model->isNewRecord ? 'Добавление места работы' : 'Изменение места работы' ?></header>

            <?php $form = ActiveForm::begin(['id' => 'exp-add']); ?>

            <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            <table>
                <tr>
                    <td>Начало работы: &nbsp;</td>
                    <td><?= $form->field($model, 'y_begin')->dropDownList(Arrays::years(),['prompt'=>'Год начала ...'])->label(false) ?></td>
                    <td><?= $form->field($model, 'm_begin')->dropDownList(Arrays::months(),['prompt'=>'Месяц начала ...'])->label(false) ?></td>
                </tr>
                <tr>
                    <td>Окончание: &nbsp;</td>
                    <td><?= $form->field($model, 'y_end')->dropDownList(Arrays::years(),['prompt'=>'Год окончания ...'])->label(false) ?></td>
                    <td><?= $form->field($model, 'm_end')->dropDownList(Arrays::months(),['prompt'=>'Месяц окончания ...'])->label(false) ?></td>
                </tr>
                <tr><td><?= $form->field($model, 'now')->checkbox() ?></td></tr>
            </table>
            <?= $form->field($model, 'experience')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'min'
            ]) ?>
            <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right', 'name' => 'edu-add-btn']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
