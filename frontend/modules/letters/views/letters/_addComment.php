<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use kartik\form\ActiveForm;
$user = Yii::$app->user->getIdentity();
$letter_id = $this->params['letter_id'];
$letter_alias = $this->params['letter_alias'];
$this->registerCss('.help-block{margin:0px;} .form-group{margin:0px;}');
?>

<div class="edu-add">
    <hr style="margin: 0px 0px 0px 0px; border: 2px solid #ddd;">
    <h6 style="margin: 3px 0px;">
        Внимание! Комментарии содержащие ненормативную лексику, оскорбления, а также комментарии не относящиеся к теме письма будут удалятся администрацией сайта.
        <i class="small-text">При повтороной публикации таких комментариев пользователь будет заблокирован.</i>
    </h6>

    <div class="container-fluid" style="padding: 2px; background-color: #c6c6c6;">
        <?php $form = ActiveForm::begin([
            'id' => 'careate-comment',
            'action' => '/letters/letters/create-comment',
        ]); ?>
        <table style="margin-bottom: 1px; width: 100%;">
            <tr>
                <td width="72px">
                    <div class="thumbnail" style="padding: 1px; margin:0px;">
                        <?= \frontend\widgets\Avatar::userAvatar($user->avatar,'67px;') ?>
                    </div>
                </td>
                <td style="">
                    <?= $form->field($model, 'text')->textarea([
                        'placeholder'=>'Оставьте свой комментарий тут.',
                        'wrap'=>'physical',
                        'rows'=>3,
                    ])->label(false) ?>
                </td>
            </tr>
        </table>
        <?= Html::submitButton('Опубликовать комментарий', ['class' => 'btn-u', 'name' => 'edu-add-btn', 'style'=>'width:100%;']) ?>
        <?= $form->field($model, 'id_letter')->hiddenInput(['value'=>$letter_id])->label(false) ?>
        <input type="hidden" name="letter" value="<?=$letter_alias?>">
        <?php ActiveForm::end(); ?>
    </div>
</div>

