<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['left'] = true;
$user = Yii::$app->user->getIdentity();
$this->title = 'Медицинские услуги доктора: '. $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Мой мед. профиль', 'url' => [Url::home() . 'med/doctors/update']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= \frontend\widgets\ProfileMenu::Menu() ?>
            <?= \yii\bootstrap\Modal::widget([
                'header' => 'Добавление медицинской услуги',
                'id' => 'serv-add-button',
                'toggleButton' => [
                    'label' => '<i class="fa fa-plus"></i>  Добавить мед услугу',
                    'class' => 'btn-u btn-u-dark',
                    'tag' => 'a',
                    'data-target' => '#serv-add-button',
                    'href' => Url::home() . 'med/doctors/serv-add',
                ],
                'clientOptions' => false,
            ]); ?>
            <br><br>

            <?php if(is_array($model)){ ?>

            <?php foreach($model as $item){ ?>
                    <?php $cost = $item->cost  !=null || $item->cost  !="" ? $item->cost : "не указана"; ?>
                <div class="panel panel-default">
                    <div class="panel-heading" style="display: inline-table; content: ' '; width: 100%;">
                    <div class="col-md-10">
                        <h3 class="panel-title"><i style="font-size: 0.8em; color: #999;">Услуга: &nbsp;</i><strong><?=$item->name?></strong>&nbsp;&nbsp;</h3>
                    </div>
                    <div class="col-md-2">
                        <?= \yii\bootstrap\Modal::widget([
                            'header' => 'Измененить мед. услугу',
                            'id' => 'serv-edit-btn-'.$item->id,
                            'toggleButton' => [
                                'label' => '<i class="fa fa-edit"></i>',
                                'class' => 'btn-u btn-u-sm btn-u-default',
                                'title'=>'Измененить мед. услугу',
                                'tag' => 'a',
                                'data-target' => '#serv-edit-btn-'.$item->id,
                                'href' => Url::home() . 'med/doctors/serv-add?id='.$item->id,
                            ],
                            'clientOptions' => false,
                        ]); ?>
                        <?= Html::a('<i class="fa fa-trash"></i>', ['del-serv', 'id'=> $item->id], [
                            'class' => 'btn-u btn-u-sm',
                            'title'=>'Удалить мед. услугу',
                            'data' => [
                                'confirm' => 'Вы действительно хотите удалить мед. услугу?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                    </div>
                    <div class="panel-body">
                        <span class="pull-right"><i class="small-text" >Стоимость: &nbsp;</i><?=$cost?> руб.</span>&nbsp;&nbsp;
                        <i>Описание: &nbsp;</i><?= $item->description !=null || $item->description !='' ? $item->description : 'нет описания' ?><br>
                    </div>
                </div>
            <?php } ?>
            <?php }else{ ?>
                <div class="tag-box tag-box-v3 margin-bottom-40">
                    <h2>Вы еще не добавили ни одной услуги!</h2>
                </div>
            <?php } ?>
            <?= \yii\bootstrap\Modal::widget([
                'header' => 'Добавление медицинской услуги',
                'id' => 'serv-add-button',
                'toggleButton' => [
                    'label' => '<i class="fa fa-plus"></i>  Добавить мед услугу',
                    'class' => 'btn-u btn-u-dark',
                    'tag' => 'a',
                    'data-target' => '#serv-add-button',
                    'href' => Url::home() . 'med/doctors/serv-add',
                ],
                'clientOptions' => false,
            ]); ?>
        </div>
    </div>
</div>
