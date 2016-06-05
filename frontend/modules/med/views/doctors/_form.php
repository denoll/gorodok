<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;
use \yii\helpers\ArrayHelper;
use \common\widgets\Arrays;
use \yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\med\Doctors */
/* @var $form yii\widgets\ActiveForm */
$this->params['left'] = true;
$spec = \common\models\med\Spec::find()->asArray()->all();

?>

<div class="doctors-form row">
    <div class="container-fluid">
        <?php $form = ActiveForm::begin(); ?>
        <div class="filter_element col-sm-12 side_left">
            <?= \frontend\widgets\ProfileMenu::Menu() ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i>&nbsp;&nbsp;Отправить данные на подтверждение' : '<i class="fa fa-check"></i>&nbsp;&nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn-u btn-u-blue' : 'btn-u btn-u-blue']) ?>
                <?php if(!$model->isNewRecord){ ?>
                <?= Html::a('<i class="fa fa-trash"></i>&nbsp;&nbsp;Удалить свои данные из каталога врачей', ['delete'], [
                    'class' => 'btn-u btn-u-red',
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить свои данные из каталога врачей?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php } ?>
        </div>
        </div>

        <div class="filter_element col-sm-6 side_left">
            <?= $form->field($model, 'id_spec')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($spec, 'id', 'name'),
                'hideSearch' => true,
                'options' => ['placeholder' => 'выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Укажите Вашу медицинскую специализацию'); ?>
        </div>
        <div class="filter_element col-sm-3 side_left">
            <?= $form->field($model, 'exp')->textInput()->label('Стаж работы (кол-во лет)'); ?>
        </div>
        <div class="filter_element col-sm-3 side_left">
            <?= $form->field($model, 'price')->textInput()->label('Стоимость приема(руб)'); ?>
        </div>
        <div class="filter_element col-sm-6">
            <?= $form->field($model, 'receiving')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Arrays::reciving(), 'id', 'name'),
                'hideSearch' => true,
                'options' => ['placeholder' => 'выберите ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Где Вы ведете прием:'); ?>
        </div>
        <div class="filter_element col-sm-12">
            <?= $form->field($model, 'rank')->textInput(['maxlength' => true])->label('Укажите Ваши, квалификацию, звание и/или ученую степень.'); ?>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('Укажите адрес, где ведёте приём пациентов.') ?>
        </div>

        <div class="filter_element col-sm-12">
            <?= $form->field($model, 'about')->textarea(['rows' => 6])->label('Кратко расскажите чем Вы занимаетесь (макс. 250 символов).'); ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i>&nbsp;&nbsp;Отправить данные на подтверждение' : '<i class="fa fa-check"></i>&nbsp;&nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn-u btn-u-blue' : 'btn-u btn-u-blue']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
