<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use \yii\jui\DatePicker;



$this->title = 'Расширенные сведения о себе';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['left'] = true;

?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= \frontend\widgets\ProfileTextBlock::init('Для полноценного отображения Ваших данных в резюме, пожалуйста заполните расширенные сведения о себе, а также об образовании и об опыте работы.','Важно!') ?>
            <?= \frontend\widgets\ProfileMenu::Menu() ?>

            <br><br>

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'education')->widget(Select2::classname(), [
                'data' => Arrays::edu(),
                'hideSearch' => true,
                'options' => ['placeholder' => 'Выберите уровень своего обазования ...'],
            ]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'sex')->widget(Select2::classname(), [
                        'data' => Arrays::sex(),
                        'hideSearch' => true,
                        'options' => ['placeholder' => 'Пол ...'],
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'birthday')->widget(DatePicker::className(), [
                        'options'=>[
                            'class'=>'form-control',
                        ],
                        'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd',
                        'clientOptions' => [
                            'yearRange' => 'c-70:c',
                            'changeYear' => true,
                            'changeMonth' => true,
                        ]
                    ]); ?>
                </div>
            </div>
            <?= $form->field($model, 'skills')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'about')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
