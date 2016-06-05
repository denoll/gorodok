<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use bupy7\cropbox\Cropbox;
use common\models\users\User;

if(User::isCompany()){
    $this->title = 'Изменение логотипа:  ' . $model->username;
    $label = \app\helpers\Texts::TEXT_CORRECT_LOGO;
}else{
    $this->title = 'Изменение Аватара:  ' . $model->username;
    $label = \app\helpers\Texts::TEXT_CORRECT_AVATAR;
}
$this->params['left'] = true;
$this->params['right'] = true;
$this->params['breadcrumbs'][] = ['label' => 'Профиль пользователя', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$labels = $model->attributeLabels();
?>

    <div class="change-login row">
        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h1 style="margin: 5px 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
                </div>
                <div class="panel-body">

                    <?php $form = ActiveForm::begin(['id' => 'change-avatar', 'class' => '', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($model, 'image')->widget(Cropbox::className(), [
                        'attributeCropInfo' => 'crop_info',
                        'pluginOptions' => [
                            'width' => \common\widgets\Arrays::IMG_SIZE_WIDTH,
                            'height' => \common\widgets\Arrays::IMG_SIZE_HEIGHT,
                            'variants' => [
                                [
                                    'width' => \common\widgets\Arrays::IMG_SIZE_WIDTH,
                                    'height' => \common\widgets\Arrays::IMG_SIZE_HEIGHT,
                                ],
                            ],
                        ],
                        'previewImagesUrl' => [
                            Yii::getAlias('@frt_url/img/avatars/') . $model['avatar']
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