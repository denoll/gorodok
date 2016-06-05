<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\widgets\Avatar;
use \common\widgets\Arrays;
/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */
$this->params['left'] = true;
$this->params['right'] = true;
$this->title = 'Резюме: '. $res['title'];
$this->params['breadcrumbs'][] = ['label' => 'Резюме', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//Resume category
$rcat = Arrays::getResumeCat($res['id']);

//Вычисляем возраст человека по его дню рождения
$now = new DateTime(date('Y-m-d'));
$vip_date = new DateTime($user['profile']['birthday']);
$_period = date_diff($now, $vip_date);
$period = $_period->y;
$y = (($period%10==1)&&($period%100!=11))?'года':'лет'
?>
<div class="job-resume-view">



    <div class="row">
        <div class="col-sm-2 side_left">
            <?= Avatar::userAvatar($user['avatar'],'100%') ?>
        </div>
        <div class="col-sm-10">
            <h3>
                <strong style="font-size: 1em; font-style: italic;">
                    <?=$user['surname'] . ' ' . $user['name'] . ' ' . $user['patronym']?>
                </strong>
            </h3>
            <p><i class="small-text">Тел:</i> <strong><?=$user['tel']?></strong>,  <i class="small-text">E-mail:</i> <strong><?=$user['email']?></strong></p>
            <p>
                <i class="small-text">Возраст:</i>&nbsp;
                <strong><?= Arrays::ageToStr($period).'. ('. Yii::$app->formatter->asDate($user['profile']['birthday'], 'long').')'?></strong>
            </p>
        </div>
    </div>
    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Желаемая должность: </p>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <div class="row">
        <div class="col-sm-8 side_left">
            <h1 style="margin-top: 2px;"><?= Html::encode($res['title']) ?></h1>
        </div>
        <div class="col-sm-4">
            <p style="margin-top: 10px;"><i class="small-text">Желаемая зарплата:</i>&nbsp;&nbsp;<strong><?= number_format($res['salary'],2,',',"'")?></strong> <i class="small-text">руб/мес.</i></p>
            <p><i class="small-text">График работы:</i>&nbsp;&nbsp;<?=Arrays::getEmployment($res['employment'])?></p>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
            <p><?=$res['description']?></p>
            <ul class="list-inline">
                <?php if(is_array($rcat)){ ?>
                    <?php foreach($rcat as $item){ ?>
                            <li><?=Html::a($item['name'],[Url::home().'jobs/resume/index', 'cat'=>$item['id']],['class'=>'btn btn-xs btn-default'])?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>

    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Опыт работы: </p>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <?php if(is_array($exp)){ ?>
    <?php foreach($exp as $item){ ?>
    <div class="row">
        <div class="col-sm-2 side_left" style="padding-top: 10px;">
            С&nbsp;&nbsp;&nbsp;<?= Arrays::getMonth($item['m_begin'],true) ?>
            <?= $item['y_begin'] ?><br>  по&nbsp;
            <?php if(($item['y_end'] == null && $item['m_end'] == null) || $item['now'] == 1){ ?>
                н.в.
            <?php } else { ?>
            <?= Arrays::getMonth($item['m_end']) ?>
            <?= $item['y_end'] ?>
            <?php } ?>
        </div>
        <div class="col-sm-10">
            <h3><?=$item['position']?></h3>
            <p style="margin-top: 0px; font-size: 1.1em; font-weight: bold; font-style: italic;">
                <?=$item['company']?>
            </p>
            <?=$item['description']?>
            <br>
            <div>
            <?=$item['experience']?>
            </div>
        </div>
        <br>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if($user['profile']['skills'] !== null ){ ?>
        <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Навыки: </p>
        <hr style="margin: 0px; border: 2px solid #ddd;">
        <?=$user['profile']['skills']?>
    <?php }?>
    <?php if($user['profile']['about'] !== null ){ ?>
    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">О себе: </p>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <?=$user['profile']['about']?>
    <?php }?>
    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Образование: <?=Arrays::getEdu($user['profile']['education'])?></p>
    <hr style="margin: 0px; border: 2px solid #ddd;">

    <?php if(is_array($edu)){ ?>
    <?php foreach($edu as $item){ ?>
        <div class="row">
            <div class="col-sm-2 side_left" style="margin-top: 10px;">
            <?=$item['end_time'] !== null ? '<i class="small-text">Окончил: </i> <strong>'.$item['end_time'].'</strong>г.' : '' ?>
            </div>
            <div class="col-sm-10">
                <h4><?=$item['name']?></h4>
                <p><?= $item['faculty'] != '' ? 'Факультет: '.$item['faculty'] : '' ?></p>
                <p><?= $item['specialty'] != '' ? 'Специальность: '.$item['specialty'] : '' ?></p>
            </div>
        </div>
    <?php } ?>
    <?php } ?>
</div>
