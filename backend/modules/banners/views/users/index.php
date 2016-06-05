<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\banners\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рекламодатели';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-users-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить нового рекламодателя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            'id',
            'company_name',
            'fio',
            'tel',
            'email:email',
            // 'description:ntext',
        ],
    ]); ?>
</div>
