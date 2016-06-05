<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;
$color = 'border: 1px solid #ddd;';
?>

<div class="item">
    <div class="margin-bottom-10">
        <div class="container-fluid" style="<?= $color ?> padding: 1px; 10px; margin: 0px;">
            <div class="col-sm-2 side_left sm-margin-bottom-20">
                <div class="thumbnail" style="padding: 1px; margin: 15px 0px 17px 0px;">
                    <?= Html::a(Avatar::userAvatar($model->avatar, '100%'), [Url::home() . 'med/doctors/view', 'id' => $model->id_user]) ?>
                </div>
            </div>
            <div class="col-md-7 side_left">

                <h2 style="margin: 5px 0px;">
                    <?= Html::a(Html::encode($model->fio), [Url::home() . 'med/doctors/view', 'id' => $model->id_user]) ?>
                </h2>
                <p style="margin: 2px;"><strong><?= $model->rank ?></strong></p>
                <p style="margin: 2px;"><i class="small-text">Стоимость приема:</i>&nbsp;&nbsp;<strong><?= number_format($model['price'],2,',',' ') ?></strong> руб.</p>
                <p style="margin: 2px;"><i class="small-text">Врач: </i>&nbsp;<strong><?= Html::a($model->spec,[Url::home() . 'med/doctors/index','cat'=>$model->id_spec]) ?></strong></p>
                <p style="margin: 2px;"><i class="small-text">О себе:&nbsp;</i><strong><?= $model->about ?></strong></p>

            </div>
            <div class="col-md-3 resume-right-col" style="margin-top: 10px;">
                <p><i class="small-text">Стаж: </i>&nbsp;<span style="font-weight: bold;"><?= Arrays::ageToStr($model->exp) ?></span></p>
                <p><i class="small-text">На сайте с:&nbsp;<?= \Yii::$app->formatter->asDate($model->created_at, 'long') ?></i></p>
            </div>
        </div>

    </div>
</div>