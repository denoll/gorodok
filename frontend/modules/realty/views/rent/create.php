<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\goods\Goods */

$this->title = 'Новое объявление об аренде недвижимости';
$this->params['breadcrumbs'][] = ['label' => 'Мои объявления', 'url' => ['my-ads']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
