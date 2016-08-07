<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\metatags\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Metatags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metatags-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Metatags', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'key',
            'url:url',
            'kw',
            'desc',
            'info',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
