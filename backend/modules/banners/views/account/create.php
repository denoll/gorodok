<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerUserAccount */

$this->title = 'Создание нового счета';
$this->params['breadcrumbs'][] = ['label' => 'Счета рекламодателей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-user-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'banner_users' => $banner_users,
        'advert' => $advert,
        'banner_items' => $banner_items,
    ]) ?>

</div>
