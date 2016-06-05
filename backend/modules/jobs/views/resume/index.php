<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\jobs\BackJobResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Резюме';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новое резюме', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
                'template' => '<div class="btn-group">{view} {update}</div> {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-eye"></i>',
                            ['view', 'id'=>$model['id']],
                            [
                                'class' => 'btn btn-sm btn-primary',
                                'title' => 'Просмотр',
                            ]
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-edit"></i>',
                            ['update', 'id'=>$model['id']],
                            [
                                'class' => 'btn btn-sm btn-success',
                                'title' => 'Изменить',
                            ]
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fa fa-trash"></i>',
                            ['delete', 'id'=>$model['id']],
                            [
                                'class' => 'btn btn-sm btn-danger',
                                'title' => 'Удалить',
                                'data' => [
                                    'confirm' => 'Вы действительно хотите удалить этот платеж?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
            [
                'attribute' => 'id_user',
                'label'=>'Пользователь',
                'value'=>'idUser.username',
                'filter' => false,
            ],
            'status',
            'title',
            'salary',
            'employment',
             'top_date',
             'vip_date',
            'id',
        ],
    ]); ?>
</div>
