<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\news\NewsCat;
use kartik\date\DatePicker;
use bupy7\cropbox\Cropbox;
use app\modules\news\Module;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;
use common\models\news\News;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;

    /* @var $this yii\web\View */
    /* @var $model common\models\News */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">
<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>
<div class="row">
    <div class="container-fluid">
        <div class="form-group">
            <div class="btn-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку новостей', ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">

<div class="col-md-3">


    <?= $form->field($model, 'id_cat')->dropDownList(
        \yii\helpers\ArrayHelper::map(NewsCat::find()->orderBy('lft')->orderBy('root')->all(), 'id', 'name')
    ) ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::className(), [
        'name' => 'activation_status',
        'pluginOptions' => [
            //'size' => 'large'
            'state' => $model->isNewRecord ? 1 : $model->status,
            'onText' => 'Опубликовано',
            'offText' => 'Не опубликовано',
            'onColor' => 'success',
            'offColor' => 'danger',
        ]
    ]) ?>


    <?= $form->field($model, 'on_main')->widget(SwitchInput::className(), [
        'name' => 'activation_main',
        'pluginOptions' => [
            //'size' => 'large'
            'state' => $model->isNewRecord ? 1 : $model->on_main,
            'onText' => 'Показать',
            'offText' => 'Скрыть',
            'onColor' => 'success',
            'offColor' => 'danger',
        ]
    ]) ?>

    <?= $form->field($model, 'publish')->widget(DatePicker::classname(), [
        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $model->isNewRecord ? '' : $model->publish,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd']]) ?>

    <?= $form->field($model, 'unpublish')->widget(DatePicker::classname(), [
        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $model->isNewRecord ? '' : $model->unpublish,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd']]) ?>

    <?= $form->field($model, 'image')->widget(Cropbox::className(), [
        'attributeCropInfo' => 'crop_info',
        'pluginOptions' => [
            'width' => \common\widgets\Arrays::IMG_SIZE_WIDTH + 50,
            'height' => \common\widgets\Arrays::IMG_SIZE_HEIGHT + 50,
            'variants' => [
                [
                    'width' => \common\widgets\Arrays::IMG_SIZE_WIDTH,
                    'height' => \common\widgets\Arrays::IMG_SIZE_HEIGHT,
                ],
            ],
        ],
        'previewImagesUrl' => [
            Yii::getAlias('@frt_url/img/news/') . $model['thumbnail']
        ],
    ]); ?>


    <div class="form-group">
        <label class="control-label">Теги для новости: </label>
        <?php
            $tags = \yii\helpers\ArrayHelper::map(\common\models\tags\Tags::find()->all(), 'name', 'name');
            $news = News::find()->with('tags')->where(['id' => $model->id])->all();
            foreach ($news as $n) {
                // as string
                //$tagValues = $n->tagValues;
                // as array
                $tagValues = $n->getTagValues(true);
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
    <?= $form->field($model, 'created_at')->widget(DatePicker::classname(), [
        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $model->isNewRecord ? '' : $model->created_at,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd']]) ?>

    <?= $form->field($model, 'modifyed_at')->widget(DatePicker::classname(), [
        'name' => 'dp_2',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'value' => $model->isNewRecord ? '' : $model->modifyed_at,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd']]) ?>

    <?= $form->field($model, 'autor')->textInput(['maxlength' => true]) ?>

</div>
<div class="col-md-9" style="padding-left: 0px;">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_text')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]); ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions(['elfinder','path'=>'news'],  [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ]),
    ]); ?>


    <?= $form->field($model, 'm_keyword')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'm_description')->textarea(['maxlength' => true]) ?>



</div>

</div>
<div class="row">
    <div class="container-fluid">
        <div class="form-group">
            <div class="btn-group">
                <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-check"></i> &nbsp;Сохранить' : '<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                <?= Html::a('<i class="fa fa-undo"></i> &nbsp;Вернуться к списку новостей', ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>
