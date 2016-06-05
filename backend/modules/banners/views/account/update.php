<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerUserAccount */

$this->title = 'Редактирование счета: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Все счета рекламодателей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
?>
<div class="banner-user-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'banner_users' => $banner_users,
        'advert' => $advert,
        'banner_items' => $banner_items,
    ]) ?>

</div>
