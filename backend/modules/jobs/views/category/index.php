<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\jobs\BackJobCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сферы деятельности';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать новую сферу деятельности', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],

            //'parent',
            'status',
            'order',
            'name',
            // 'description',
            // 'm_keyword',
            // 'm_description',
        ],
    ]); ?>
</div>
