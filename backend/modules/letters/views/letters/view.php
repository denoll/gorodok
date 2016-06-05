<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Letters */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Коллективные письма', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letters-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить это письмо?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_cat',
            'id_tags',
            'status',
            'publish',
            'unpublish',
            'title',
            'alias',
            'subtitle',
            'short_text:ntext',
            'text:ntext',
            'created_at',
            'updated_at',
            'author',
            'm_keyword',
            'm_description',
            'icon',
            'thumbnail',
            'images',
        ],
    ]) ?>

</div>
