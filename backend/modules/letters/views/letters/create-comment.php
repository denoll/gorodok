<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
?>

    <div class="change-login">
        <div class="container-fluid" style="padding: 25px 10px 25px 10px;">
            <div class="container-fluid">
                <button class="close" aria-label="Close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                <header style="margin-bottom: 20px;">Комментарий</header>

                <?php $form = ActiveForm::begin(['id' => 'create-comment', 'class' => '']); ?>

                <?= $form->field($model, 'text')->textarea()->label('<i>Введите текст комментария</i>') ?>

                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right', 'name' => 'change-password-button']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
