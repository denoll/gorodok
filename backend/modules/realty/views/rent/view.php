<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\realty\RealtyRent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Realty Rents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-rent-view">

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
            'id_cat',
            'id_user',
            'status',
            'buy',
            'name',
            'cost',
            'area_home',
            'area_land',
            'floor',
            'floor_home',
            'resell',
            'in_city',
            'type',
            'repair',
            'elec',
            'gas',
            'water',
            'heating',
            'tel_line',
            'internet',
            'distance',
            'main_img',
            'address',
            'description:ntext',
            'created_at',
            'updated_at',
            'vip_date',
            'adv_date',
            'm_keyword',
            'm_description',
            'count_img',
        ],
    ]) ?>

</div>
