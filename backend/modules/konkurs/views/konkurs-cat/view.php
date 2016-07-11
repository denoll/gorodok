<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\KonkursCat */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории конкурсов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-cat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'conkonkurs' => 'Вы действительно хотите удалить эту категорию? ВНИМАНИЕ при удалении категории удалятся все конкурсовы входящие в эту категорию',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_parent',
            'status',
            'order',
            'name',
            'slug',
            'mk',
            'md',
        ],
    ]) ?>

</div>
