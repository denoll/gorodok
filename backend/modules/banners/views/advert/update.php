<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerAdv */

$this->title = 'Изменение рекламной компании: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рекламные компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
?>
<div class="banner-adv-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
