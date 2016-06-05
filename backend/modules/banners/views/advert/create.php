<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerAdv */

$this->title = 'Создание новой рекламной компании';
$this->params['breadcrumbs'][] = ['label' => 'Рекламные компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-adv-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
