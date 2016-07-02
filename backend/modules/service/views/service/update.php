<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\service\Service */

$this->title = 'Изменение объявления об услуге: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="goods-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
