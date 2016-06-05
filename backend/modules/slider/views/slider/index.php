<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фото на главной';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slider-main-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новое фото', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user.username',
            'name',
            [
                'attribute'=>'status',
                'format'=>'boolean',
                'value'=>'status',
                'label'=>'Активно',
            ],
            [
                'attribute' => 'thumbnail',
                'label' => 'Фото',
                'format' => 'raw',
                'options' => ['width' => '60'],
                'filter' => false,
                'value' => function($data){
                    if($data->thumbnail != null || $data->thumbnail != '') {
                        return Html::img(Url::to('@frt_url/img/slider/' . $data->thumbnail), [
                            'alt' => 'Фото',
                            'style' => 'width:31px;'
                        ]);
                    }else{
                        return Html::img(Url::to('@frt_url/img/avatars/avatar_128.png'), [
                            'alt' => 'Аватар',
                            'style' => 'width:31px;'
                        ]);
                    }
                },
            ],
            'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
