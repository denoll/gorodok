<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ForumTheme */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Forum Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-theme-view">

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
            'id_author',
            'status',
            'order',
            'to_top',
            'name',
            'alias',
            'created_at',
            'modify_at',
            'description',
            'm_keyword',
            'm_description',
        ],
    ]) ?>

</div>
