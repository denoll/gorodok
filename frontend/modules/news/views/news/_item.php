<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;

?>
<div class="item">
    <div class="margin-bottom-10">
        <div class="container-fluid" style="border: 1px solid #D9D9D9; padding: 1px; 10px; margin: 0px;">
            <div class="col-sm-3 side_left sm-margin-bottom-20">
                <div class="thumbnail" style="padding: 1px; margin: 15px 0px 17px 0px;">
                    <?= Html::a(Avatar::imgNews($model['thumbnail'], '100%'), [Url::to('/news/news/view'),'cat'=>$model['cat']['alias'], 'id' => $model['alias']]) ?>
                </div>
            </div>
            <div class="col-md-9">

                <h2 style="font-size: 1.25em; margin: 3px 0px;">
                    <?= Html::a(Html::encode($model['title']), [Url::to('/news/news/view'),'cat'=>$model['cat']['alias'], 'id' => $model['alias']]) ?>
                </h2>
                <p style="margin: 2px 0;"><i class="small-text">Дата новости:&nbsp;<?= \Yii::$app->formatter->asDate($model['publish'], 'long') ?></i>
                <span style="padding-left: 15px;"><i class="small-text">Категория:&nbsp;&nbsp;</i><strong><?=Html::a($model['cat']['name'],['/news/news/index','cat'=>$model['cat']['alias']])?></strong></span>
                </p>
                <p style="margin: 2px 0;"><?= $model['autor'] ? '<i class="small-text">Автор:&nbsp;</i>'. $model['autor'] : ''?></p>
                <div style="text-align: justify;"><?= $model['short_text'] ;?></div>
                <div class="container-fluid" style="margin-left:5px; padding: 5px; width: 100%;">
                    <?php
                    if (!empty($model['tags'])) {
                        echo '<span style="margin-right: 15px;">Теги: </span>';
                        foreach ($model['tags'] as $tagName) {
                            echo Html::a($tagName['name'],['/tags/tags/index','tag'=>$tagName['name']],['class'=>'tags tag_btn']);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>