<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\users\UserAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->widget(Select2::classname(), [
        'language' => 'ru',
        'data' => ArrayHelper::map($users,'id','username'),
        'options' => ['placeholder' => 'Выберите пользователя ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'pay_in')->textInput(['maxlength' => true])->label('Сумма платежа (руб)') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $model->isNewRecord ? '' : $model->date,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd']])->label('Дата платежа')
    ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'service')->hiddenInput(['value'=>'Пополнение баланса'])->label(false) ?>

    <div class="form-group">
        <?php echo Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
