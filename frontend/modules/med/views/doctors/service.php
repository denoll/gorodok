<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->params['left'] = true;

$this->title = 'Медицинские услуги доктора: '. $user['fio'];
$this->params['breadcrumbs'][] = ['label' => 'Врачи', 'url' => ['/med/doctors/index']];
$this->params['breadcrumbs'][] = ['label' => 'Мед. профиль', 'url' => ['/med/doctors/view', 'id'=>$user['id_user']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <br>
            <?php if(is_array($model)){ ?>

            <?php foreach($model as $item){ ?>
                    <?php $cost = $item['cost']  !=null || $item['cost']  !="" ? $item['cost'] : "не указана"; ?>
                <div class="panel panel-default">
                    <div class="panel-heading" style="display: inline-table; content: ' '; width: 100%;">
                    <div class="col-md-8">
                        <h3 class="panel-title"><i style="font-size: 0.8em; color: #999;">Услуга: &nbsp;</i><strong><?=$item['name']?></strong>&nbsp;&nbsp;</h3>
                    </div>
                    <div class="col-md-4">
                        <span class="pull-right"><i class="small-text" >Стоимость: &nbsp;</i><strong><?= number_format($cost,2,',',' ') ?></strong> руб.</span>&nbsp;&nbsp;
                    </div>
                    </div>
                    <div class="panel-body">
                        <i>Описание: &nbsp;</i><?= $item['description'] !=null || $item['description'] !='' ? $item['description'] : 'нет описания' ?><br>
                    </div>
                </div>
            <?php } ?>
            <?php }else{ ?>
                <div class="tag-box tag-box-v3 margin-bottom-40">
                    <h2>Доктор не указал дополнительных услуг.</h2>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
