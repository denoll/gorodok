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

$letter = \common\models\letters\Letters::findOne($letter_id);

	$this->title = 'Комментрарии к письму: '.$letter->title;

    $this->params['breadcrumbs'][] = $this->title;
    $yes_no = [
        ['id' => '0', 'name' => 'Нет'],
        ['id' => '1', 'name' => 'Да'],
    ];
?>
<div class="letters-index">

    <div class="box box-default">
        <div class="box-header with-border">
            <div class="row">
                <div class="container-fluid">
                    <div class="form-group">
                        <div class="btn-group">
                            <?= Html::a('<i class="fa fa-list-alt"></i> &nbsp;Перейти назад к письмам', '/letters/letters/index', ['class' => 'btn btn-default']) ?>
                            <?= \yii\bootstrap\Modal::widget([
                                'header' => '<i>Добавить комментарий</i>',
                                'id' => 'create-comment-btn',
                                'toggleButton' => [
                                    'label' => '<i class="fa fa-plus"></i>Добавить комментарий',
                                    'class' => 'btn btn-info',
                                    'style' => 'text-align:center;',
                                    'tag' => 'a',
                                    'data-target' => '#create-comment-btn',
                                    'href' => '/letters/letters/create-comment?letter='.$letter_id,
                                ],
                                'clientOptions' => false,
                            ]); ?>
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
                'pjax' => false, // pjax is set to always true for this demo
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
	                [
		                'class' => 'yii\grid\ActionColumn',
		                'contentOptions' => ['style' => 'width: 125px; min-width: 125px;'],
		                'template' => '{update-comment} {delete-comment}',
		                'buttons' => [

			                'update-comment' => function ($url,$model,$key) {
				                return \yii\bootstrap\Modal::widget([
                                    'header' => '<i>Изменить комментарий</i>',
                                    'id' => 'update-comment-btn',
                                    'toggleButton' => [
                                        'label' => '<i class="fa fa-edit"></i>',
                                        'title' => 'Изменить комментарий',
                                        'class' => 'btn btn-sm btn-info',
                                        'style' => 'text-align:center;',
                                        'tag' => 'a',
                                        'data-target' => '#update-comment-btn',
                                        'href' => $url, //'/letters/letters/update-comment?letter='.$letter_id,
                                    ],
                                    'clientOptions' => false,
                                ]);
			                },
			                'delete-comment' => function ($url,$model,$key) {
				                return Html::a(
					                '<i class="fa fa-trash"></i>',
					                $url,
					                [
						                'class' => 'btn btn-sm btn-danger',
						                'title' => 'Удалить комментарий',
						                'data' => [
							                'confirm' => 'Вы действительно хотите удалить этот комментарий?',
							                'method' => 'post',
						                ],
					                ]
				                );
			                },
		                ],
	                ],
                    [
                        'attribute' => 'status',
                        'label' => 'Опубликован',
                        'format' => 'raw',
                        'filter' => \yii\helpers\ArrayHelper::map($yes_no, 'id', 'name'),
                        'options' => ['width' => '70'],
                        'value' => function($data){
                            if($data['status'] == 1){
                                return Html::button('<i class="fa fa-check"></i>',['class' => 'btn btn-sm btn-success', 'id'=>'status_'.$data['id'], 'onclick' => 'changeCommentStatus('.$data['id'].')','title'=>'Изменить статус']);
                            }else{
                                return Html::button('<i  class="fa fa-minus"></i>',['class' => 'btn btn-sm btn-danger', 'id'=>'status_'.$data['id'], 'onclick' => 'changeCommentStatus('.$data['id'].')','title'=>'Изменить статус']);
                            }
                        },
                    ],
                    [
                        'attribute' => 'id_user',
                        'label' => 'Пользователь',
                        'value' => 'user.username',
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\users\User::find()->all(), 'id', 'username'),
                    ],

                    'text',
                    //['class' => 'yii\grid\ActionColumn'],
                    [
                        'attribute' => 'id',
                        'label' => 'ID',
                        'options' => ['width' => '50']
                    ],
                    'created_at',
                    'updated_at',

                ],
            ]); ?>
        </div>
    </div>
</div>
