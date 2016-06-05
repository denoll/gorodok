<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerUsers */

$this->title = 'Редактирование рекламодателя: ' . ' ' . $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Рекламодатели', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Рекдактирование';
?>
<div class="banner-users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
