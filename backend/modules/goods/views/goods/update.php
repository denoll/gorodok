<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\goods\Goods */

$this->title = 'Изменение объявления от товаре: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="goods-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
