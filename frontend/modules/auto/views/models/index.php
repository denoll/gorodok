<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\auto\ModelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auto Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-models-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Auto Models', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'brand_id',
            'item_type',
            'version',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
