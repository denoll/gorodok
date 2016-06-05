<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\web\View;
$this->params['left'] = true;

$this->title = 'Сведения об опыте работы';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;
//'education', 'skills', 'about', 'experience'
?>

<div class="jobs-default-index">
    <form action="#" id="sky-form4" class="sky-form">

    </form>
    <div class="panel panel-dark">

        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= \frontend\widgets\ProfileTextBlock::init('Для полноценного отображения Ваших данных в резюме, пожалуйста заполните расширенные сведения о себе, а также об образовании и об опыте работы.','Важно!') ?>
            <?= \frontend\widgets\ProfileMenu::Menu() ?>
            <?= \yii\bootstrap\Modal::widget([
                'header' => 'Добавление места работы',
                'id' => 'exp-add-button',
                'toggleButton' => [
                    'label' => '<i class="fa fa-plus"></i>  Добавить место работы',
                    'class' => 'btn-u btn-u-dark',
                    'tag' => 'a',
                    'data-target' => '#exp-add-button',
                    'href' => Url::home() . 'jobs/job-profile/exp-add',
                ],
                'clientOptions' => false,
            ]); ?>
            <br><br>

            <?php if(is_array($model)){ ?>

            <?php foreach($model as $item){ ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?= \yii\bootstrap\Modal::widget([
                            'header' => 'Изменить сведения об опыте работы',
                            'id' => 'edu-edit-btn-'.$item->id,
                            'toggleButton' => [
                                'label' => '<h3 class="panel-title"><i style="font-size: 0.8em; color: #999;">Организация: &nbsp;</i><strong>'. $item->company . '</strong>  &nbsp;<i style="font-size: 0.8em; color: #999;">' . $item->period() . '</i></h3>',
                                'class' => '',
                                'tag' => 'a',
                                'data-target' => '#edu-edit-btn-'.$item->id,
                                'href' => Url::home() . 'jobs/job-profile/exp-add?id='.$item->id,
                            ],
                            'clientOptions' => false,
                        ]); ?>

                    </div>
                    <div class="panel-body">
                        <?= $item->position !=null || $item->position !='' ? '<h4 style="margin: 5px 0px; line-height: 14px;"><i class="lab">Должность: &nbsp;</i><strong>'. $item->position .'</strong></h4>' : '' ?>

                        <?= $item->description !=null || $item->description !='' ? '<i class="lab">Описание деятельности компании: &nbsp;</i><br>'. $item->description : '' ?><br>

                        <?= $item->experience !=null || $item->experience !='' ? '<i class="lab">Обязанности, функции, достижения: &nbsp;</i><br>'. $item->experience : '' ?><br>

                        <?= $item->site !=null || $item->site !='' ? '<i class="lab">Сайт организации: &nbsp;</i><a target="_blank" href="http://'.$item->site.'">'. $item->site .'</a>' : '' ?>
                    </div>
                </div>
            <?php } ?>
            <?php }else{ ?>
                <div class="tag-box tag-box-v3 margin-bottom-40">
                    <h2>Вы еще не указали сведения о своем опыте работы!</h2>
                </div>
            <?php } ?>
            <?= \yii\bootstrap\Modal::widget([
                'header' => 'Добавление места работы',
                'id' => 'exp-add-btn',
                'toggleButton' => [
                    'label' => '<i class="fa fa-plus"></i>  Добавить место работы',
                    'class' => 'btn-u btn-u-dark',
                    'tag' => 'a',
                    'data-target' => '#exp-add-btn',
                    'href' => Url::home() . 'jobs/job-profile/exp-add',
                ],
                'clientOptions' => false,
            ]); ?>
        </div>
    </div>
</div>
<?php


?>