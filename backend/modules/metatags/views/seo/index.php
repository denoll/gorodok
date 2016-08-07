<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\metatags\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'СЕО мета теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metatags-index">
    <p>
        <?= Html::a('Добавить страницу с метатегами', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
            'key',
            'url:url',
            'kw',
            'desc',
            'info',
        ],
    ]); ?>
</div>
