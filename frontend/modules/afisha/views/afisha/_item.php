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
                    <?= Html::a(Avatar::imgAfisha($model['thumbnail'], '100%'), ['/afisha/afisha/view','cat'=>$model['cat']['alias'], 'id' => $model['alias']]) ?>
                </div>
            </div>
            <div class="col-md-9">

                <h2 style="font-size: 1.25em; margin: 3px 0px;">
                    <?= Html::a(Html::encode($model['title']), ['/afisha/afisha/view','cat'=>$model['cat']['alias'], 'id' => $model['alias']]) ?>
                </h2>
                <p style="margin: 2px 0;">
                    <strong class="small-text">Дата:&nbsp;<?= \Yii::$app->formatter->asDate($model['date_in'], 'long') ?></strong>
                    <?php if(!empty($model['date_out'])){ ?>
                        &nbsp; - &nbsp;
                        <strong class="small-text"><?= \Yii::$app->formatter->asDate($model['date_out'], 'long') ?></strong>
                    <?php } ?>
                    <br><span><i class="small-text">Категория:&nbsp;&nbsp;</i><strong><?=Html::a($model['cat']['name'],['/afisha/afisha/index','cat'=>$model['cat']['alias']])?></strong></span><br>
                    <span><i class="small-text">Место мероприятия:&nbsp;&nbsp;</i><strong><?= $model['place']['name'] ?></strong></span>
                </p>
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