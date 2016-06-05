<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ForumsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Форумы управление';
$this->params['breadcrumbs'][] = $this->title;
	$status = [
		['id'=>'0','name'=>'Заблокирован'],
		['id'=>'1','name'=>'Активный'],
//		['id'=>'2','name'=>'Административный'],
//		['id'=>'3','name'=>'Архив',]
	];
	$yes_no = [
		['id'=> '0', 'name' => 'Нет'],
		['id'=> '1', 'name' => 'Да'],
	];
?>
<div class="forums-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новый форум', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
	        [
		        'class' => 'yii\grid\ActionColumn',
		        'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
		        'template' => '<div class="btn-group">{view} {update}</div> {delete}',
		        'buttons' => [
			        'view' => function ($url,$model,$key) {
				        return Html::a(
					        '<i class="fa fa-eye"></i>',
					        $url,
					        [
						        'class' => 'btn btn-sm btn-success',
						        'title' => 'Просмотр',
					        ]
				        );
			        },
			        'update' => function ($url,$model,$key) {
				        return Html::a(
					        '<i class="fa fa-edit"></i>',
					        $url,
					        [
						        'class' => 'btn btn-sm btn-primary',
						        'title' => 'Редактировать',
					        ]
				        );
			        },
			        'delete' => function ($url,$model,$key) {
				        return Html::a(
					        '<i class="fa fa-trash"></i>',
					        $url,
					        [
						        'class' => 'btn btn-sm btn-danger',
						        'title' => 'Удалить',
						        'data' => [
							        'confirm' => 'Вы действительно хотите удалить этот форум?',
							        'method' => 'post',
						        ],
					        ]
				        );
			        },
		        ],
	        ],
	        [
		        'attribute' => 'id',
		        'label'=>'ID',
		        'options' => ['width' => '70']
	        ],
	        [
		        'attribute' => 'order',
		        'label'=>'Порядок',
		        'options' => ['width' => '80']
	        ],
	        [
		        'attribute' => 'status',
		        'label' => 'Статус',
		        //'format' => 'boolean',
		        'filter' => \yii\helpers\ArrayHelper::map($status,'id', 'name'),
		        'value' => function ($data) {
			        if ($data->status == '1') {
				        return 'Активный';
			        } else {
				        return 'Заблокирован';
			        }
		        },
		        'options' => ['style' => 'width: 90px; max-width: 90px;'],
		        'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
	        ],
	        [
		        'attribute' => 'on_main',
		        'label' => 'На главной',
		        'format' => 'boolean',
		        'filter' => \yii\helpers\ArrayHelper::map($yes_no,'id', 'name'),
		        'value' => 'on_main',
		        'options' => ['style' => 'width: 90px; max-width: 90px;'],
		        'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
	        ],
            //'status',
	        //'on_main',
            'name',
            'alias',
	        [
		        'attribute' => 'created_at',
		        'label' => 'Дата создания',
		        'format' =>  ['date', 'dd.MM.YYYY'],
		        'options' => ['width' => '100']
	        ],

            // 'modify_at',
            // 'description',
            // 'm_keywords',
            // 'm_description',


        ],
    ]); ?>

</div>
