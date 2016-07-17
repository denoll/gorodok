<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\auto\ModifySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auto Modifies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-modify-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Auto Modify', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'model_id',
            'version_id',
            'y_from',
            // 'y_to',
            // 'item_type',
            // 'version',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
