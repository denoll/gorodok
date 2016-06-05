<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerUsers */

$this->title = 'Добавление нового рекламодателя';
$this->params['breadcrumbs'][] = ['label' => 'Рекламодатели', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
