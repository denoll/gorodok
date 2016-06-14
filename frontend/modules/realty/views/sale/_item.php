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

if ($period <= $const['vip']  && $model['vip_date'] !== null) {
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
                    <?= Html::a(Avatar::imgRealtySale($model['main_img'], '100%'), ['/realty/sale/view', 'cat'=>$model['alias'], 'id' => $model['id']]) ?>
                </div>
            </div>
            <div class="col-md-7 side_left">
                <h2 style="margin: 5px 0px;">
                    <?= $star ? Avatar::Star() : '&nbsp;' ?>&nbsp;
                    <?= Html::a(Html::encode($model['name']), ['/realty/sale/view', 'cat'=>$model['alias'], 'id' => $model['id']]) ?>
                </h2>
                <p><i class="small-text">Категория:&nbsp;</i><strong><?= Html::a($model['category'], ['index','cat'=>$model['alias']]); ?></strong></p>
                <p><i class="small-text">Описание:&nbsp;</i><strong><?= $model['description'] != '' ? mb_strimwidth($model['description'],0,180). ' ...' : ' - отсутствует' ;?></strong></p>

            </div>
            <div class="col-md-3 resume-right-col" style="margin-top: 10px;">
                <p><i class="small-text">Цена: </i>&nbsp;<span style="font-weight: bold;"><?= $model['cost'] ? number_format($model['cost'],2,',',"'").'&nbsp;<i class="small-text">Руб. </i>' :' - не задана' ?></span></p>
                <p><i class="small-text"><?= \Yii::$app->formatter->asDate($model['created_at'], 'long') ?></i></p>
                <p><i class="small-text">Автор:&nbsp;<?= $model['company'] ? ' Компания ':' Частное лицо ' ?></i></p>
                <p><?= $model['company'] ? $model['company_name'] : $model['username']?></p>
            </div>
        </div>

    </div>
</div>