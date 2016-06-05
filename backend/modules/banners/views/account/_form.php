<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/** @var $this yii\web\View */
/** @var $model common\models\banners\BannerUserAccount */
/** @var $banner_users common\models\banners\BannerUsers */
/** @var $advert common\models\banners\BannerAdv */
/** @var $banner_items common\models\banners\BannerItem */
/** @var $form yii\widgets\ActiveForm */
?>

<div class="banner-user-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->dropDownList(ArrayHelper::map($banner_users, 'id', 'company_name'),['prompt'=>'Выберите рекламодателя ...']) ?>

    <?//= $form->field($model, 'id_advert')->dropDownList(ArrayHelper::map($advert, 'id', 'name'),['prompt'=>'Выберите рекламную компанию ...']) ?>

    <?= $form->field($model, 'pay_in')->textInput(['maxlength' => true])->label('Сумма платежа') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $model->isNewRecord ? '' : $model->date,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd']])
    ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'service')->hiddenInput(['value'=>'Пополнение баланса'])->label(false) ?>

    <div class="form-group">
        <?php echo Html::submitButton('<i class="fa fa-save"></i>&nbsp;&nbsp;Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
