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
$this->title = 'Вакансия: '. $vac['title'];
$this->params['breadcrumbs'][] = ['label' => 'Вакансии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//Vacancy category
$vcat = Arrays::getVacanyCat($vac['id']);

?>
<div class="job-resume-view">



    <div class="row">
        <div class="col-sm-2 side_left">
            <?= Avatar::userAvatar($user['avatar'],'100%') ?>
        </div>
        <div class="col-sm-10">
            <h3><i class="small-text">В компанию:</i>&nbsp;
                <strong style="font-size: 1em; font-style: italic;">
                    <?= $user['company']['name'] ?>
                </strong>
            </h3>
            <hr style="margin: 0px; border: 1px solid #ddd;">
            <p style="margin-top: 10px;"><i class="small-text">Телефон:</i>&nbsp;<strong><?= $user['tel'] != null ? $user['tel'] : ' не указан ' ?></strong>,&nbsp;&nbsp;
                <i class="small-text">E-mail:</i>&nbsp;<strong><?=$user['email']?></strong>,&nbsp;&nbsp;
                <i class="small-text">Сайт:</i>&nbsp;<strong><?= $user['company']['site'] != null ? Html::a($user['company']['site'], $user['company']['site'], ['target'=>'_blank'])  : ' не указан ' ?></strong>
            </p>
            <hr style="margin: 0px 0px 10px 0px; border: 1px solid #ddd;">
            <ul class="list-inline">
                <?php if(is_array($vcat)){ ?>
                    <?php foreach($vcat as $item){ ?>
                        <li><?=Html::a($item['name'],[Url::home().'jobs/vacancy/index', 'cat'=>$item['id']],['class'=>'btn btn-xs btn-default'])?></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    </div>
    <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Требуется: </p>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <div class="row">
        <div class="col-sm-8 side_left">
            <h1 style="margin-top: 2px;"><?= Html::encode($vac['title']) ?></h1>
        </div>
        <div class="col-sm-4">
            <p style="margin-top: 10px;"><i class="small-text">Ожидаемый доход:</i>&nbsp;&nbsp;<strong><?= number_format($vac['salary'],2,',',"'")?></strong> <i class="small-text">руб/мес.</i></p>
            <p><i class="small-text">График работы:</i>&nbsp;&nbsp;<?=Arrays::getEmployment($vac['employment'])?></p>
        </div>
    </div>
    <div class="row">
        <div class="container-fluid">
            <p><?= $vac['description'] ?></p>

        </div>
    </div>


    <div>
        <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Обязанности: </p>
        <hr style="margin: 0px; border: 2px solid #ddd;">
        <div><?= $vac['duties'] != null || $vac['duties'] != '' ? $vac['duties'] : 'Не указаны' ?></div>
        <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Требования: </p>
        <hr style="margin: 0px; border: 2px solid #ddd;">
        <div><?= $vac['require'] != null || $vac['require'] != '' ? $vac['require'] : 'Не указаны' ?></div>
        <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Условия: </p>
        <hr style="margin: 0px; border: 2px solid #ddd;">
        <div><?= $vac['conditions'] != null || $vac['conditions'] != '' ? $vac['conditions'] : 'Не указаны' ?></div>
    </div>

</div>
