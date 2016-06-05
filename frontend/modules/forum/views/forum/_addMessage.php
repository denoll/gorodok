<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use kartik\form\ActiveForm;
use kartik\widgets\SwitchInput;

$user = Yii::$app->user->getIdentity();
$theme_id = $this->params['theme_id'];
$theme_alias = $this->params['theme_alias'];
$id_cat = $this->params['id_cat'];
$this->registerCss('.help-block{margin:0px;} .form-group{margin:0px;}');
$status = [
    '0' => 'Видно только мне и автору темы',
    '1' => 'Видно всем',
];
$model->status = 1;
?>

<div class="edu-add margin-bottom-20">
    <hr style="margin: 0px 0px 0px 0px; border: 2px solid #ddd;">
    <h6 style="margin: 3px 0px;">
        <strong style="color: #A90000;">Внимание!</strong> Ответы содержащие ненормативную лексику, оскорбления, а также, ответы не относящиеся к теме форума будут удалятся администрацией сайта.
        <i class="small-text">При повтороной публикации таких сообщений пользователь будет заблокирован.</i>
    </h6>

    <div class="container-fluid" style="padding: 2px; background-color: #c6c6c6;">
        <?php $form = ActiveForm::begin([
            'id' => 'create-message',
            'action' => '/forum/forum/create-message',
        ]); ?>
        <table style="margin-bottom: 1px; width: 100%;">
            <tr>
                <td>
                    <div class="radio_buttons">
                        <div>
                            <input type="radio" name="ForumMessage[status]" id="radio1" value="1" checked />
                            <label for="radio1">Сообщение видно всем</label>
                        </div>
                        <div>
                            <input type="radio" name="ForumMessage[status]" id="radio2" value="0" />
                            <label for="radio2">Только мне и автору темы</label>
                        </div>
                    </div>

                    <?= $form->field($model, 'message')->textarea([
                        'placeholder' => 'Напишите свой ответ тут.',
                        'wrap' => 'physical',
                        'rows' => 6,
                    ])->label(false) ?>
                </td>
            </tr>
        </table>
        <?= Html::submitButton('Опубликовать ответ', ['class' => 'btn-u', 'name' => 'edu-add-btn', 'style' => 'width:100%;']) ?>
        <?= $form->field($model, 'id_cat')->hiddenInput(['value' => $id_cat])->label(false) ?>
        <?= $form->field($model, 'id_theme')->hiddenInput(['value' => $theme_id])->label(false) ?>
        <input type="hidden" name="theme_alias" value="<?= $theme_alias ?>">
        <?php ActiveForm::end(); ?>
    </div>
</div>
