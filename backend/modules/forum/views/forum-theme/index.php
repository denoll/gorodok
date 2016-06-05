<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\models\forum\ForumCat;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ForumThemeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


	$this->title = 'Темы форума: ';
	$this->params['breadcrumbs'][] = $this->title;
	$status = [
		['id'=>'0','name'=>'Видно только админу'],
		['id'=>'1','name'=>'Видно всем'],
		['id'=>'2','name'=>'Видно только автору',]
	];
	$yes_no = [
		['id'=> '0', 'name' => 'Нет'],
		['id'=> '1', 'name' => 'Да'],
	];
?>
<div class="forum-theme-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новую тему', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
		        [
			        'class' => 'yii\grid\ActionColumn',
			        'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
			        'template' => '<div class="btn-group">{message} {update}</div> {delete}',
			        'buttons' => [
				        'message' => function ($url,$model,$key) {
					        return Html::a(
						        '<i class="fa fa-comments-o"></i>',
						        $url,
						        [
							        'class' => 'btn btn-sm btn-success',
							        'title' => 'Перейти к сообщениям по этой теме',
						        ]
					        );
				        },
				        'update' => function ($url,$model,$key) {
					        return Html::a(
						        '<i class="fa fa-edit"></i>',
						        $url,
						        [
							        'class' => 'btn btn-sm btn-primary',
							        'title' => 'Редактировать тему',
						        ]
					        );
				        },
				        'delete' => function ($url,$model,$key) {
					        return Html::a(
						        '<i class="fa fa-trash"></i>',
						        $url,
						        [
							        'class' => 'btn btn-sm btn-danger',
							        'title' => 'Удалить тему',
							        'data' => [
								        'confirm' => 'Вы действительно хотите удалить эту тему?',
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
			        'format' => 'raw',
			        'filter' => \yii\helpers\ArrayHelper::map($status,'id', 'name'),
			        'value' => 'status',
			        'options' => ['style' => 'width: 90px; max-width: 90px;'],
			        'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
		        ],
		        [
			        'attribute' => 'id_cat',
			        'label' => 'Категория форума',
			        'value' => 'idCat.name',
			        'format' => 'raw',
			        'filterType' => GridView::FILTER_SELECT2,
			        'filter' => \yii\helpers\ArrayHelper::map(ForumCat::find()->all(), 'id', 'name'),
			        'filterWidgetOptions' => [
				        'pluginOptions' => ['allowClear' => true],
			        ],
			        'filterInputOptions' => ['placeholder' => 'Форум ...'],
		        ],

		        'name',
		        [
			        'attribute' => 'created_at',
			        'label' => 'Дата создания',
			        'format' =>  ['date', 'dd.MM.YYYY'],
			        'options' => ['width' => '100']
		        ],
	            [
		            'attribute' => 'id_author',
		            'label' => 'Автор',
		            'value' => 'idAuthor.username',
		            'format' => 'raw',
	            ],
            //'id_author',
            //'status',
            //'order',
            // 'to_top',
            // 'name',
            // 'alias',
            // 'created_at',
            // 'modify_at',
            // 'description',
            // 'm_keyword',
            // 'm_description',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
