<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\slider\SliderMain */

$this->title = 'Редактирование фото: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фото на главной', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="slider-main-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
