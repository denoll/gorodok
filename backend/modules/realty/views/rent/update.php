<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\realty\RealtyRent */

$this->title = 'Изменение объявления об аренде недвижимости: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Объявления об аренде недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменение объявления';
?>
<div class="realty-rent-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
