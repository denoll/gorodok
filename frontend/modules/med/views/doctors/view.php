<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\Avatar;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\med\Doctors */

if (!empty($model['m_description'])) {
    $this->registerMetaTag(['content' => Html::encode($model['m_description']), 'name' => 'description']);
}
if (!empty($model['m_keyword'])) {
    $this->registerMetaTag(['content' => Html::encode($model['m_keyword']), 'name' => 'keywords']);
}

$this->params['right'] = true;
$this->params['left'] = true;
$this->title = $model['fio'] != '' ? $model['fio'] : $model['username'];
$this->params['breadcrumbs'][] = ['label' => 'Врачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user->getIdentity();
?>
<div class="doctors-view">
    <div class="form-group">
        <?php if ($user->id === $model['id_user'] && $user->doctor) { ?>
            <?= Html::a('<i class="fa fa-edit"></i>&nbsp;&nbsp;Редактировать свои медицинские данные', ['update'], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-sm-3 side_left">
            <div class="tumbnail" style="padding: 2px;"><?= Avatar::userAvatar($model['avatar'], '100%') ?></div>
        </div>
        <div class="col-sm-9">
            <h1><strong style="font-size: 0.9em; font-style: italic;"><?= $model['fio'] ?></strong></h1>
            <h4 style="margin: 2px;"><?= Html::a(Html::encode($model['spec']), [Url::home() . 'med/doctors/index', 'cat' => $model['id_spec']], ['class' => '']) ?> &nbsp;-&nbsp; <?= Html::encode($model['rank']) ?></h4>

            <p style="margin: 2px;"><i class="small-text">Тел:</i> <strong><?= $model['tel'] ?></strong>, <i class="small-text">E-mail:</i> <strong><?= $model['email'] ?></strong></p>

            <p style="margin: 2px;"><i class="small-text">Стаж работы:</i>&nbsp;<strong><?= Arrays::ageToStr($model['exp']) ?></strong></p>

            <p style="margin: 2px;"><i class="small-text">Ведет прием:</i>&nbsp;&nbsp;<strong><?= Arrays::getReciving($model['receiving']) ?></strong></p>
            <p style="margin: 2px;">
                <i class="small-text">Стоимость приема:</i>&nbsp;&nbsp;<strong><?= number_format($model['price'],2,',',' ') ?></strong> руб.
                <i class="small-text">&nbsp;&nbsp; Еше услуги: </i><?= Html::a('Открыть',['service', 'id'=>$model['id_user']]) ?>
            </p>
            <p><?= $model['description'] ?></p>
        </div>
    </div>
    <hr style="margin: 0px; border: 2px solid #ddd;">

    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Опыт работы: </p>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <?php if (is_array($exp)) { ?>
        <?php foreach ($exp as $item) { ?>
            <div class="row">
                <div class="col-sm-2 side_left" style="padding-top: 10px;">
                    С&nbsp;&nbsp;&nbsp;<?= Arrays::getMonth($item['m_begin'], true) ?>
                    <?= $item['y_begin'] ?><br> по&nbsp;
                    <?php if (($item['y_end'] == null && $item['m_end'] == null) || $item['now'] == 1) { ?>
                        н.в.
                    <?php } else { ?>
                        <?= Arrays::getMonth($item['m_end']) ?>
                        <?= $item['y_end'] ?>
                    <?php } ?>
                </div>
                <div class="col-sm-10">
                    <h3><?= $item['position'] ?></h3>

                    <p style="margin-top: 0px; font-size: 1.1em; font-weight: bold; font-style: italic;">
                        <?= $item['company'] ?>
                    </p>
                </div>
                <br>
            </div>
        <?php } ?>
    <?php } ?>

    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Образование: </p>
    <hr style="margin: 0px; border: 2px solid #ddd;">

    <?php if (is_array($edu)) { ?>
        <?php foreach ($edu as $item) { ?>
            <div class="row">
                <div class="col-sm-2 side_left" style="margin-top: 10px;">
                    <?= $item['end_time'] !== null ? '<i class="small-text">Окончил: </i> <strong>' . $item['end_time'] . '</strong>г.' : '' ?>
                </div>
                <div class="col-sm-10">
                    <h4><?= $item['name'] ?></h4>

                    <p><?= $item['faculty'] != '' ? 'Факультет: ' . $item['faculty'] : '' ?></p>

                    <p><?= $item['specialty'] != '' ? 'Специальность: ' . $item['specialty'] : '' ?></p>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>
