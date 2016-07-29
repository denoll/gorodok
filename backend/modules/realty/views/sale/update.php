<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\realty\RealtySale */

$this->title = 'Изменение объявления о продаже недвижимости: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Объявления о продаже недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменение объявления';
?>
<div class="realty-sale-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
