<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use app\modules\letters\assets\LettersAsset;

    /* @var $this yii\web\View */
    /* @var $searchModel common\models\search\LettersSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */
LettersAsset::register($this);

	$this->title = 'Коллективные письма';

    $this->params['breadcrumbs'][] = $this->title;
    $yes_no = [
        ['id' => '0', 'name' => 'Нет'],
        ['id' => '1', 'name' => 'Да'],
    ];
?>
<div class="letters-index">

    <div class="box box-default">
        <div class="box-header with-border">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="row">
                <div class="container-fluid">
                    <div class="form-group">
                        <div class="btn-group">
                            <?= Html::a('<i class="fa fa-plus"></i> &nbsp;Создать новое коллективное письмо', ['create'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('<i class="fa fa-list-alt"></i> &nbsp;Перейти к категориям писем', Url::home() . 'letters/letters/category', ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
	                [
		                'class' => 'yii\grid\ActionColumn',
		                'contentOptions' => ['style' => 'width: 125px; min-width: 125px;'],
		                'template' => '{comments}{update} {delete}',
		                'buttons' => [
                            'comments' => function ($url,$model,$key) {
                                return Html::a(
                                    '<i class="fa fa-comments"></i>',
                                    $url,
                                    [
                                        'class' => 'btn btn-sm btn-info',
                                        'title' => 'Комментарии к письму',
                                    ]
                                );
                            },
			                'update' => function ($url,$model,$key) {
				                return Html::a(
					                '<i class="fa fa-edit"></i>',
					                $url,
					                [
						                'class' => 'btn btn-sm btn-primary',
						                'title' => 'Редактировать письмо',
					                ]
				                );
			                },
			                'delete' => function ($url,$model,$key) {
				                return Html::a(
					                '<i class="fa fa-trash"></i>',
					                $url,
					                [
						                'class' => 'btn btn-sm btn-danger',
						                'title' => 'Удалить письмо',
						                'data' => [
							                'confirm' => 'Вы действительно хотите удалить это письмо?',
							                'method' => 'post',
						                ],
					                ]
				                );
			                },
		                ],
	                ],
                    [
                        'attribute' => 'status',
                        'label' => 'Опубликована',
                        'format' => 'raw',
                        'filter' => \yii\helpers\ArrayHelper::map($yes_no, 'id', 'name'),
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
                        'attribute' => 'on_main',
                        'label' => 'На главной',
                        'format' => 'raw',
                        'filter' => \yii\helpers\ArrayHelper::map($yes_no, 'id', 'name'),
                        'options' => ['width' => '70'],
                        'value' => function($data){
                            if($data['on_main'] == 1){
                                return Html::button('<i class="fa fa-check"></i>',['class' => 'btn btn-sm btn-success', 'id'=>'on_main_'.$data['id'], 'onclick' => 'changeOnMain('.$data['id'].')','title'=>'Изменить статус']);
                            }else{
                                return Html::button('<i  class="fa fa-minus"></i>',['class' => 'btn btn-sm btn-danger', 'id'=>'on_main_'.$data['id'], 'onclick' => 'changeOnMain('.$data['id'].')','title'=>'Изменить статус']);
                            }
                        },
                    ],
                    [
                        'attribute' => 'thumbnail',
                        'label' => 'Фото',
                        'format' => 'raw',
                        'options' => ['width' => '70'],
                        'filter' => false,
                        'value' => function($data){
                            if($data['thumbnail'] != null || $data['thumbnail'] != '') {
                                return Html::img(Url::to('@frt_url/img/letters/' . $data['thumbnail']), [
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
                        'attribute' => 'id_cat',
                        'label' => 'Категория',
                        'value' => 'cat.name',
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\letters\LettersCat::find()->orderBy('lft')->orderBy('root')->all(), 'id', 'name'),
                    ],
                    'title',
                    'comments_count',
                    'rating',
                    'vote_yes',
                    'vote_no',
                    'created_at',
                    [
                        'attribute' => 'id',
                        'label' => 'ID',
                        'options' => ['width' => '50']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
