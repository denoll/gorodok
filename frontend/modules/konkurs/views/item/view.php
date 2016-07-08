<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursItem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Konkurs Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-item-view">

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
            'id_konkurs',
            'id_user',
            'base_url:url',
            'img',
            'description',
            'created_at',
            'updated_at',
            'status',
            'yes',
            'no',
            'scope',
        ],
    ]) ?>

</div>
