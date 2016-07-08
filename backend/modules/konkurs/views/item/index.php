<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\konkurs\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Konkurs Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Konkurs Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_konkurs',
            'id_user',
            'base_url:url',
            'img',
            // 'description',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'yes',
            // 'no',
            // 'scope',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
