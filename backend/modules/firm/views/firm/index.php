<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\firm\FirmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фирмы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новую фирму', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_cat',
            'id_user',
            'status',
            'show_requisites',
            'name',
            'tel',
            'email:email',
            'site',
            'logo:image',
            'address',
            // 'description:ntext',
            // 'created_at',
            // 'updated_at',
            // 'mk',
            // 'md',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
