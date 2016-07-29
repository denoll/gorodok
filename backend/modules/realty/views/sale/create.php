<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\realty\RealtySale */

$this->title = 'Создание объявления о продаже недвижимости';
$this->params['breadcrumbs'][] = ['label' => 'Объявления о продаже недвижимости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-sale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
