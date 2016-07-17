<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoModify */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auto Modifies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-modify-view">

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
            'name:ntext',
            'model_id',
            'version_id',
            'y_from',
            'y_to',
            'item_type',
            'version',
        ],
    ]) ?>

</div>
