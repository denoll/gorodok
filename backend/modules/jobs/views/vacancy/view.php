<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobVacancy */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Job Vacancies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-vacancy-view">

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
            'id_user',
            'status',
            'top_date',
            'vip_date',
            'title',
            'description:ntext',
            'employment',
            'salary',
            'education',
            'address',
            'duties:ntext',
            'require:ntext',
            'conditions:ntext',
            'created_at',
            'updated_at',
            'm_keyword',
            'm_description',
        ],
    ]) ?>

</div>
