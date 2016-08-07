<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Metatags */

$this->title = $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Metatags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metatags-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->key], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->key], [
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
            'key',
            'url:url',
            'kw',
            'desc',
            'info',
        ],
    ]) ?>

</div>
