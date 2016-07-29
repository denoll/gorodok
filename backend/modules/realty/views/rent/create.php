<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\realty\RealtyRent */

$this->title = 'Создание объявления об аренде недвижимости';
$this->params['breadcrumbs'][] = ['label' => 'Объявления об аренде недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-rent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
