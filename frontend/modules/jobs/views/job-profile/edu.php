<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['left'] = true;

$this->title = 'Сведения об образовании';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;
//'education', 'skills', 'about', 'experience'
?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= \frontend\widgets\ProfileTextBlock::init('Для полноценного отображения Ваших данных в резюме, пожалуйста заполните расширенные сведения о себе, а также об образовании и об опыте работы.','Важно!') ?>
            <?= \frontend\widgets\ProfileMenu::Menu() ?>
            <?= \yii\bootstrap\Modal::widget([
                'header' => 'Добавление сведений об образовании',
                'id' => 'edu-add-button',
                'toggleButton' => [
                    'label' => '<i class="fa fa-plus"></i>  Добавить место учебы',
                    'class' => 'btn-u btn-u-dark',
                    'tag' => 'a',
                    'data-target' => '#edu-add-button',
                    'href' => Url::home() . 'jobs/job-profile/edu-add',
                ],
                'clientOptions' => false,
            ]); ?>
            <br><br>

            <?php if(is_array($model)){ ?>

            <?php foreach($model as $item){ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= \yii\bootstrap\Modal::widget([
                            'header' => 'Изменение сведений об образовании',
                            'id' => 'edu-edit-btn-'.$item->id,
                            'toggleButton' => [
                                'label' => '<h3 class="panel-title"><i style="font-size: 0.8em; color: #999;">Уч. заведение: &nbsp;</i><strong>'. $item->name . '</strong></h3>',
                                'class' => '',
                                'tag' => 'a',
                                'data-target' => '#edu-edit-btn-'.$item->id,
                                'href' => Url::home() . 'jobs/job-profile/edu-add?id='.$item->id,
                            ],
                            'clientOptions' => false,
                        ]); ?>
                    </div>
                    <div class="panel-body">
                        <?= $item->end_time !=null || $item->end_time !='' ? '<i>Год окончания: &nbsp;</i>'. $item->end_time : '' ?><br>
                        <?= $item->faculty !=null || $item->faculty !='' ? '<i>Факультет: &nbsp;</i>'. $item->faculty : '' ?><br>
                        <?= $item->specialty !=null || $item->specialty !='' ? '<i>Специальность: &nbsp;</i>'. $item->specialty : '' ?>
                    </div>
                </div>
            <?php } ?>
            <?php }else{ ?>
                <div class="tag-box tag-box-v3 margin-bottom-40">
                    <h2>Вы еще не указали сведения об образовании!</h2>
                </div>
            <?php } ?>
            <?//=Html::a('<i class="fa fa-plus"></i>  Добавить сведения об образовании',['edu-add'],['class'=>'btn-u btn-u-dark'])?>
            <?= \yii\bootstrap\Modal::widget([
                'header' => 'Добавление сведений об образовании',
                'id' => 'edu-add-btn',
                'toggleButton' => [
                    'label' => '<i class="fa fa-plus"></i>  Добавить место учебы',
                    'class' => 'btn-u btn-u-dark',
                    'tag' => 'a',
                    'data-target' => '#edu-add-btn',
                    'href' => Url::home() . 'jobs/job-profile/edu-add',
                ],
                'clientOptions' => false,
            ]); ?>
        </div>
    </div>
</div>
