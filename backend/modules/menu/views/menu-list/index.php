<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\menu\models\MenuListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
	$status = [
		['id' => '0', 'name' => 'Нет'],
		['id' => '1', 'name' => 'Да'],
	];
$this->title = 'Меню';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="menu-list-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= \yii\bootstrap\Modal::widget([
	        'id' => 'menu-create',
	        'toggleButton' => [
		        'label' => '<i class="fa-fw fa fa-plus" style="margin-right: 12px;"></i>Создать новое меню',
		        'class' => 'btn btn-success',
		        'style' => 'width: 250px; font-size: 0.9em; color: #fff; padding: 5px 7px 5px 7px; text-align:center',
		        'tag' => 'a',
		        'data-target' => '#menu-create',
		        'href' => Url::home() . 'menu/menu-list/create',
	        ],
	        'clientOptions' => false,
        ]); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'class' => 'yii\grid\ActionColumn',
		        'contentOptions' => ['style' => 'width: 102px;'],
		        'template' => '{items} {update} {delete}',
		        'buttons' => [
			        'items' => function ($url, $model, $key) {
				        return Html::a(
					        '<i class="fa fa-navicon"></i>',
					        $url,
					        [
						        'class' => 'btn btn-xs btn-success',
						        'title' => 'Элементы меню',
					        ]
				        );
			        },
			        'update' => function ($url, $model, $key) {
				        return \yii\bootstrap\Modal::widget([
					        'id' => 'menu-edit_' . $key,
					        'toggleButton' => [
						        'label' => '<i class="fa fa-edit"></i>',
						        'title' => 'Редактировать',
						        'class' => 'btn btn-xs btn-primary',
						        'tag' => 'a',
						        'data-target' => '#menu-edit_' . $key,
						        'href' => $url,
					        ],
					        'clientOptions' => false,
				        ]);
			        },
			        'delete' => function ($url, $model, $key) {
				        return Html::a(
					        '<i class="fa fa-trash"></i>',
					        $url,
					        [
						        'class' => 'btn btn-xs btn-danger',
						        'title' => 'Удалить',
						        'data' => [
							        'confirm' => 'Вы действительно хотите удалить это меню?',
							        'method' => 'post',
						        ],
					        ]
				        );
			        },
		        ],
	        ],
            'title',
            'alias',
            'position',
	        [
		        'attribute' => 'status',
		        'label' => 'Активно',
		        'format' => 'boolean',
		        'filter' => \yii\helpers\ArrayHelper::map($status, 'id', 'name'),
		        'value' => 'status',
		        'options' => ['style' => 'width: 70px;'],
		        'contentOptions' => ['style' => 'width: 70px;'],
	        ],
	        [
		        'attribute' => 'id',
		        'options' => ['width' => '70']
	        ],

        ],
    ]); ?>

</div>
