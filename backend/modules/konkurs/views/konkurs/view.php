<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Konkurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-view">

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
            'name',
            'slug',
            'status',
            'show_img',
            'show_des',
            'stars',
            'title',
            'description:ntext',
            'main_img',
            'width',
            'height',
            'start',
            'stop',
            'created_at',
            'updated_at',
            'mk',
            'md',
        ],
    ]) ?>

</div>
