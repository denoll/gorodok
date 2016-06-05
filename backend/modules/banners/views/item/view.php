<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Banner Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_adv_company',
            'id_user',
            'banner_key',
            'path',
            'size',
            'url:url',
            'caption',
            'status',
            'order',
            'created_at',
            'updated_at',
            'click_count',
            'max_click',
            'start',
            'stop',
        ],
    ]) ?>

</div>
