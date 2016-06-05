<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\widgets\AdsSlider;
use common\widgets\Arrays;
use common\widgets\RealtyArrays;

/* @var $this yii\web\View */
/* @var $model common\models\goods\Goods */
$ses = Yii::$app->session;
$ses->open();
$cur_cat = $ses->get('current_cat');
$parent_cat = $ses->get('parent_cat');
$first_child = $ses->get('first_child');
$ses->close();

if (!empty($model['m_description'])) {
    $this->registerMetaTag(['content' => Html::encode($model['m_description']), 'name' => 'description']);
}else{
    $this->registerMetaTag(['content' => Html::encode($cur_cat['m_description']), 'name' => 'description']);
}
if (!empty($model['m_keyword'])) {
    $this->registerMetaTag(['content' => Html::encode($model['m_keyword']), 'name' => 'keywords']);
}else{
    $this->registerMetaTag(['content' => Html::encode($cur_cat['m_keyword']), 'name' => 'keywords']);
}
$this->params['left'] = true;
$this->params['right'] = true;
$this->title = $model['name'];
$this->params['breadcrumbs'][] = ['label' => 'Объявления об аренде недвижимости', 'url' => ['index']];
if(!empty($parent_cat)){
    foreach($parent_cat as $cat){
        $this->params['breadcrumbs'][] = ['label' => $cat['name'], 'url' => [Url::to('index'), 'cat'=>$cat['alias']]];
    }
}
if(!empty($cur_cat)) {
    $this->params['breadcrumbs'][] = ['label' =>  $cur_cat['name'], 'url' => ['index', 'cat'=>$cur_cat['alias']]];
}
//$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user->getIdentity();
$path = Url::to('@frt_url/img/realty_rent/');
?>
<div class="goods-view">
    <div class="row">
        <div class="col-sm-12">
            <h1><strong style="font-size: 0.9em; font-style: italic;"><?= $model['name'] ?></strong></h1>
        </div>
        <div class="col-sm-7 side_left">
            <div class="thumbnail" style="padding: 2px;"><?= AdsSlider::run($path,$images, '100%') ?></div>
        </div>
        <div class="col-sm-5">
            <?php if ($user->id === $model['id_user']) { ?>
                <?= Html::a('<i class="fa fa-edit"></i>&nbsp;&nbsp;Редактировать это объявление', [Url::to('/realty/rent/update'), 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
            <?php } ?>
            <?php if ($model['company']) { ?>
                <h4><i class="small-text" style="font-size: 0.7em;">Продавец:</i><br><strong style="font-size: 0.9em; font-style: italic;"><?= $model['username'] ?></strong></h4>
                <h4><i class="small-text" style="font-size: 0.7em;">Контактное лицо:</i><br><strong style="font-size: 0.9em; font-style: italic;"><?= $model['fio'] ?></strong></h4>
            <?php } else { ?>
                <h4><i class="small-text" style="font-size: 0.7em;">Продавец:</i><strong style="font-size: 0.9em; font-style: italic;"><?= $model['fio'] ?></strong></h4>
            <?php } ?>
            <p style="margin: 2px;"><i class="small-text">Тел:</i> <strong><?= $model['tel'] == '' ? ' - не указан': $model['tel'] ?></strong></p>

            <p style="margin: 2px;"><i class="small-text">E-mail:</i> <strong><?= $model['email'] ?></strong></p>
            <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #555;"><i class="small-text">Цена: </i>&nbsp;<span style="font-weight: bold;"><?= $model['cost'] !='' ? number_format($model['cost'],2,',',"'"). '&nbsp;<i class="small-text">Руб. </i>' : ' - не указана' ?></span></p>
        </div>
    </div>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <div class="row">
        <div class="col-sm-2">
            <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Информация: </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h4><i class="small-text" style="font-size: 0.7em;">Адрес:</i><strong style="font-size: 0.9em; font-style: italic;"><?= $model['address'] ?></strong></h4>
            <h4 style="margin: 2px;"><i class="small-text" style="font-size: 0.7em;">Категория:</i><?= Html::a(Html::encode($model['category']), [Url::to('/service/service/index'), 'cat' => $model['alias']], ['class' => '']) ?></h4>

            <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Подробнее: </p>
        </div>
        <div class="col-md-4">
            <?php if($model['in_city']){ ?>
                <p><i class="small-text">Объект находится: </i> в пределах города.</p>
            <?php }else{ ?>
                <p><i class="small-text">Объект находится в: </i> <?=$model['distance']?> <i class="small-text">км от города.</i></p>
            <?php } ?>
            <?php if($model['resell'] !== null){ ?>
                <p><i class="small-text">Тип недвижимости: </i> <?= RealtyArrays::getRealtyResell($model['resell']) ?></p>
            <?php } ?>
            <?php if($model['type'] !== null){ ?>
                <p><i class="small-text">Тип строения (дома): </i> <?= RealtyArrays::getHomeType($model['type']) ?></p>
            <?php } ?>
            <?php if($model['repair'] !== null){ ?>
                <p><i class="small-text">Состояние (ремонт): </i> <?= RealtyArrays::getRealtyRepair($model['repair']) ?></p>
            <?php } ?>
        </div>
        <div class="col-md-4">
            <?php if($model['area_home'] !== null){ ?>
                <p><i class="small-text">Площадь (м2): </i> <?= $model['area_home'] ?></p>
            <?php } ?>
            <?php if($model['area_land'] !== null){ ?>
                <p><i class="small-text">Площадь участка (сотка): </i> <?= $model['area_land'] ?></p>
            <?php } ?>
            <?php if($model['floor'] !== null){ ?>
                <p><i class="small-text">Этаж: </i> <?= $model['floor'] ?></p>
            <?php } ?>
            <?php if($model['floor_home'] !== null){ ?>
                <p><i class="small-text">Этажей в доме: </i> <?= $model['floor_home'] ?></p>
            <?php } ?>
        </div>
        <div class="col-md-4">
            <?php if($model['elec'] !== null){ ?>
                <p><i class="small-text">Электричество: </i> <?= RealtyArrays::getYesNo($model['elec']) ?></p>
            <?php } ?>
            <?php if($model['gas'] !== null){ ?>
                <p><i class="small-text">Газ: </i> <?= RealtyArrays::getYesNo($model['gas']) ?></p>
            <?php } ?>
            <?php if($model['water'] !== null){ ?>
                <p><i class="small-text">Вода: </i> <?= RealtyArrays::getYesNo($model['water']) ?></p>
            <?php } ?>
            <?php if($model['heating'] !== null){ ?>
                <p><i class="small-text">Отопление: </i> <?= RealtyArrays::getYesNo($model['heating']) ?></p>
            <?php } ?>
            <?php if($model['tel_line'] !== null){ ?>
                <p><i class="small-text">Телефон: </i> <?= RealtyArrays::getYesNo($model['tel_line']) ?></p>
            <?php } ?>
            <?php if($model['internet'] !== null){ ?>
                <p><i class="small-text">Интернет: </i> <?= RealtyArrays::getYesNo($model['internet']) ?></p>
            <?php } ?>
        </div>
        <div class="col-md-12">
            <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Описание: </p>
            <p><?= $model['description'] != '' ? nl2br($model['description']) : ' Отсутствует' ?></p>
        </div>
    </div>


</div>
