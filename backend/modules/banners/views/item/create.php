<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */

$this->title = 'Создание нового рекламного баннера';
$this->params['breadcrumbs'][] = ['label' => 'Все рекламные баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'advert' => $advert,
        'blocks' => $blocks,
    ]) ?>

</div>
