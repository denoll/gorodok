<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\service\Service */

$this->title = 'Новое объявление';
$this->params['breadcrumbs'][] = ['label' => 'Все услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
