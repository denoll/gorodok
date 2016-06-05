<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use kartik\tree\TreeViewInput;
use common\models\letters\LettersCat;
use bupy7\cropbox\Cropbox;
use yii\captcha\Captcha;
use yii\web\View;
use yii\widgets\Pjax;
use denoll\editor\CKEditor as CKEditor;
/* @var $this yii\web\View */
/* @var $model common\models\letters\Letters */
/* @var $form yii\widgets\ActiveForm */
$this->params['left'] = true;
$label = 'Выберите картинку или фото и подгоните выбраный файл под размер с помощью колесика мышки.';

?>

<div class="letters-form row">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-sm-6 side_left">
        <?= $form->field($model, 'id_cat')->widget(TreeViewInput::classname(),[
            'query' => LettersCat::find()->addOrderBy('root, lft'),
            'headingOptions' => ['label' => 'Укажите категорию'],
            'value' => true,
            'rootOptions' => ['label' => '<span class="text-primary">Кореневая директория</span>'],
            'options' => [
                'placeholder' => 'выберите категорию для письма...',
                'disabled' => false
            ],
            'fontAwesome' => true,     // optional
            'asDropdown' => true,            // will render the tree input widget as a dropdown.
            'multiple' => false,            // set to false if you do not need multiple selection
        ])->label('Выберите категорию (Выбирать можно только конечные категории помеченные синими иконками).'); ?>

        <div class="form-group">
            <label class="control-label">Теги для письма: </label>
            <?php
            $tags = \yii\helpers\ArrayHelper::map(\common\models\tags\Tags::find()->all(), 'name', 'name');
            $letters = \common\models\letters\Letters::find()->with('tags')->where(['id' => $model->id])->all();
            foreach ($letters as $item) {
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
    <div class="col-sm-6">
        <?= $form->field($model, 'image')->widget(Cropbox::className(), [
            'attributeCropInfo' => 'crop_info',
            'pluginOptions' => [
                'width' => 350,
                'height' => 350,
                'variants' => [
                    [
                        'width' => 250,
                        'height' => 250,
                    ],
                ],
            ],
            'previewImagesUrl' => [
                Yii::getAlias('@frt_url/img/letters/') . $model['thumbnail']
            ],
        ])->label($label); ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Укажите заголовок письма'); ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'short_text')->textarea(['maxlength' => true])->label('Укажите краткий анонс письма (до 500 символов).'); ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'text')->widget(CKEditor::className(), [
            'options' => [
                //'rows' => 15,
                //'resize_minHeight' => 400
            ],
            'preset' => 'min'
        ])->label('Заполните полный текст письма.'); ?>
    </div>
    <div class="col-sm-12">
        <?php if ($model->isNewRecord) { ?>
            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'captchaAction' => '/site/captcha',
                'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-4" style="margin: 5px 0px;">{input}</div></div>',
            ]) ?>
        <?php } ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Подать письмо на публикацию' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php

$js = <<< JS
    $("#w1-tree").treeview("collapseAll");
JS;
$this->registerJs($js, View::POS_END);
?>
