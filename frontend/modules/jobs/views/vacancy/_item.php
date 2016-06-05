<?php
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;
//Вычисляем период между текущей датой и датой получения статуса vip
$const = Arrays::getConst();
$vip_date = strtotime($model['vip_date']);
$now = strtotime(date('Y-m-d'));
$period =  intval(abs(($now - $vip_date)/(3600*24)));

if ($period <= $const['vip']  && $model->vip_date !== null) {
    $color = 'background-color: rgba(145,201,72, 0.5);';
    $star = true;
}else{
    $color = 'border: 1px solid #ddd;';
    $star = false;
}
?>

<div class="item">
    <div class="margin-bottom-10">
        <div class="container-fluid" style="<?= $color ?> padding: 1px; 10px; margin: 0px;">
            <div class="col-sm-2 side_left sm-margin-bottom-20">
                <div class="thumbnail" style="padding: 1px; margin: 15px 0px 17px 0px;">
                    <?= Html::a(Avatar::userAvatar($model->avatar, '100%'), [Url::home() . 'jobs/vacancy/view', 'id' => $model->id]) ?>
                </div>
            </div>
            <div class="col-md-7 side_left">

                <h2 style="margin: 5px 0px;">
                    <?= $star ? Avatar::Star() : '&nbsp;' ?>&nbsp;
                    <?= Html::a(Html::encode($model->title), [Url::home() . 'jobs/vacancy/view', 'id' => $model->id]) ?>
                </h2>
                <p><i class="small-text">Компания:&nbsp;</i><strong><?= $model->name ?></strong></p>
                <p><i class="small-text">Описание:&nbsp;</i><strong><?= mb_strimwidth($model->description,0,303);?> ...</strong></p>

            </div>
            <div class="col-md-3 resume-right-col" style="margin-top: 10px;">
                <p><i class="small-text">З/п: </i>&nbsp;<span style="font-weight: bold;"><?= number_format($model->salary,2,',',"'") ?></span>&nbsp;<i class="small-text">Руб. </i></p>
                <p><i class="small-text"><?= \Yii::$app->formatter->asDate($model->updated_at, 'long') ?></i></p>



            </div>
        </div>

    </div>
</div>