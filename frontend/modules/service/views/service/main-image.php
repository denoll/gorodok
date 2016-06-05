<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use bupy7\cropbox\Cropbox;
use common\models\users\User;


    $this->title = 'Изменение фото объявления:  ' . $model['name'];
    $label = 'Выберите новое фото и подгоните выбраный файл под размер с помощью колесика мышки.';

$this->params['left'] = true;

$this->params['breadcrumbs'][] = ['label' => 'Профиль пользователя', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$labels = $model->attributeLabels();
?>

    <div class="change-login row">
        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h1 style="margin: 5px 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="panel-body">

                    <?php $form = ActiveForm::begin(['id' => 'main-image', 'class' => '', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($model, 'image')->widget(Cropbox::className(), [
                        'attributeCropInfo' => 'crop_info',
                        'pluginOptions' => [
                            'width' => 250,
                            'height' => 250,
                            'variants' => [
                                [
                                    'width' => 250,
                                    'height' => 250,
                                ],
                            ],
                        ],
                        'previewImagesUrl' => [
                            Yii::getAlias('@frt_url/img/goods/') . $model['main_img']
                        ],
                    ])->label($label); ?>
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'change-password-button']) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php

?>