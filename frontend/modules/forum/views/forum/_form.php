<?php

use common\models\User;
use common\models\forum\ForumCat;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use denoll\editor\CKEditor;
use kartik\widgets\SwitchInput;
use kartik\date\DatePicker;
use kartik\widgets\Select2;

$this->params['left'] = true;
$this->params['right'] = true;
/* @var $this yii\web\View */
/* @var $model common\models\ForumTheme */
/* @var $form yii\widgets\ActiveForm */
$settings = [
    'lang' => 'ru',
    'minHeight' => 200,
    'source' => false,
    'linkNofollow' => true,
    'deniedTags' => ['style', 'script', 'a', 'img'],
    'plugins' => [
        'fontcolor',
        'fullscreen',
        'table',
    ],
];
$status = \common\widgets\Arrays::forumThemeStatus(true);
?>

<div class="forum-theme-form">


    <div class="row">

        <?php $form = ActiveForm::begin(); ?>
        <div class="container-fluid">
            <div style="width: 100%; margin: 0px auto 5px auto; padding: 3px 3px; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => 'btn-u btn-xs btn-u-dark']) ?>
                <?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку тем', ['category', 'id' => $alias_cat], ['class' => 'btn-u btn-xs btn-brd btn-u-default']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Теги для темы (не больше 3-х тегов): </label>
                <?php
                $tags = \yii\helpers\ArrayHelper::map(\common\models\tags\Tags::find()->all(), 'name', 'name');
                $ft = \common\models\forum\ForumTheme::find()->with('tags')->where(['id' => $model->id])->all();
                foreach ($ft as $item) {
                    // as string
                    //$tagValues = $item->tagValues;
                    // as array
                    $tagValues = $item->getTagValues(true);
                }
                if ($tagNames != null || $tagNames != '') {
                    $model->tagValues = $tagValues;
                }
                //echo $form->field($model, 'tagValues')->widget(Select2::classname(), [
                echo Select2::widget([
                    'model' => $model,
                    'attribute' => 'tagValues',
                    'value' => $model->isNewRecord ? '' : $tagValues,
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $tags,
                    'options' => [
                        'placeholder' => 'Добавьте теги ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 15,
                        'allowClear' => true,
                    ],
                ]);
                ?>
                <br>

                <div class="container-fluid" style="margin-left:5px; padding: 5px; width: 100%;">
                    <?php
                    if (is_array($tagValues)) {
                        foreach ($tagValues as $i => $tagName) {
                            echo '<span class="tags">';
                            echo $tagName;
                            echo '</span>&nbsp;';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label">Статус темы: </label>

            <div class="thumbnail" style="padding-left: 10px;">
                <?php $model->status = $model->isNewRecord ? 1 : $model->status; ?>
                <?= $form->field($model, 'status')->radioList($status, [
                    'inline' => true,
                ])->label(false); ?>
            </div>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'min',
            ]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>