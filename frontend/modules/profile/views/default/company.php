<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use \yii\jui\DatePicker;

$this->params['left'] = true;

$this->title = 'Данные о компании';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= Html::a('Сведения о компании', [Url::home() . 'profile/company'], ['class' => 'btn-u btn-u-dark-blue']) ?>
            <?= Html::a('Вакансии', [Url::home() . 'jobs/vacancy/my-vacancy'], ['class' => 'btn-u btn-u-purple']) ?>
            <br><br>

            <?php $form = ActiveForm::begin(); ?>


            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'legal_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
                </div>
            </div>

            <h4>Реквизиты компании: </h4>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'INN')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'KPP')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'legal_address')->textarea(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'BIK')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-9">
                    <?= $form->field($model, 'BANK')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'R_S')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'K_S')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
