<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\modules\goods\assets\GoodsAsset;
/* @var $this yii\web\View */
/* @var $searchModel common\models\goods\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
GoodsAsset::register($this);
$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
//$ip = \Yii::$app->getRequest()->getUserIP();
$status = [
    ['id' => '1', 'name' => 'Активный'],
    ['id' => '0' , 'name' => 'Заблокирован'],
];

//$model = $dataProvider->getModels();


?>
<div class="goods-index" style="margin-bottom: 75px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id',
                'label'=>'№ объявления',
                'filter'=>false,
                'options' => ['width' => '70']
            ],
            [
                'attribute'=>'category',
                'label'=>'Категория',
                'filter'=>false,
            ],
            [
                'attribute'=>'username',
                'label'=>'Владелец объявления',
                'filter'=>false,
            ],
            [
                'attribute'=>'name',
                'label'=>'Товар',
                'filter'=>false,
            ],
            [
                'attribute'=>'cost',
                'label'=>'Цена',
                'filter'=>false,
            ],
            [
                'attribute'=>'created_at',
                'label'=>'Дата создания',
                'filter'=>false,
            ],
            [
                'attribute'=>'updated_at',
                'label'=>'Дата поднятия',
                'filter'=>false,
            ],
            [
                'attribute'=>'vip_date',
                'label'=>'Дата выделения',
                'filter'=>false,
            ],
            [
                'attribute' => 'main_img',
                'label' => 'Фото',
                'format' => 'raw',
                'options' => ['width' => '70'],
                'filter' => false,
                'value' => function($data){
                    if($data['main_img'] != null || $data['main_img'] != '') {
                        return Html::img(Url::to('@frt_url/img/goods/' . $data['main_img']), [
                            'alt' => 'Фото',
                            'style' => 'width:31px;'
                        ]);
                    }else{
                        return Html::img(Url::to('@frt_url/img/no-img.png'), [
                            'alt' => 'Фото',
                            'style' => 'width:31px;'
                        ]);
                    }
                },
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'format' => 'raw',
                'filter' => false, // \yii\helpers\ArrayHelper::map($status, 'id', 'name'),
                'options' => ['width' => '70'],
                'value' => function($data){
                    if($data['status'] == 1){
                        return Html::button('<i class="fa fa-check"></i>',['class' => 'btn btn-sm btn-success', 'id'=>'status_'.$data['id'], 'onclick' => 'changeStatus('.$data['id'].')','title'=>'Изменить статус']);
                    }else{
                        return Html::button('<i  class="fa fa-minus"></i>',['class' => 'btn btn-sm btn-danger', 'id'=>'status_'.$data['id'], 'onclick' => 'changeStatus('.$data['id'].')','title'=>'Изменить статус']);
                    }
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
                'template' => '<div class="btn-group">{view} {update}</div> {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-eye"></i>',
                            ['/goods/goods/view', 'id'=>$model['id']],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'title' => 'Просмотр',
                            ]
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-edit"></i>',
                            ['/goods/goods/update', 'id'=>$model['id']],
                            [
                                'class' => 'btn btn-sm btn-success',
                                'title' => 'Изменить',
                            ]
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-trash"></i>',
                            ['/goods/goods/delete', 'id'=>$model['id']],
                            [
                                'class' => 'btn btn-sm btn-danger',
                                'title' => 'Удалить',
                                'data' => [
                                    'confirm' => 'Вы действительно хотите удалить это объявление?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
