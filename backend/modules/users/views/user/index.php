<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\users\assets\UsersAsset;
use app\modules\users\helpers\CountryCodes;
	use kartik\ipinfo\IpInfo;
	UsersAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\users\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
	//$ip = \Yii::$app->getRequest()->getUserIP();
	$status = [
		['id' => '10', 'name' => 'Активный'],
		['id' => '0' , 'name' => 'Заблокирован'],
	];
?>
<div class="user-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<br>
    <p>
        <?= Html::a('<i class="fa fa-user-plus"></i>  Добавить нового пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
	    'layout'=>"{pager}\n{summary}\n{items}",
        'columns' => [
	        [
		        'attribute' => 'id',
		        'label' => 'ID',
		        'options' => ['width' => '70']
	        ],
            'username',
            'email',
            'name',
            'surname',
            // 'patronym',
            // 'confirmed_at',
            // 'blocked_at',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'rating',
            // 'flags',
            // 'lat',
            // 'long',
            // 'ip',
	        [
		        'attribute' => 'status',
		        'label' => 'Статус',
		        'format' => 'raw',
		        'filter' => \yii\helpers\ArrayHelper::map($status, 'id', 'name'),
		        'options' => ['width' => '70'],
		        'value' => function($data){
			            if($data->status == 10){
				            return Html::button('<i class="fa fa-check"></i>',['class' => 'btn btn-sm btn-success', 'id'=>'status_'.$data->id, 'onclick' => 'changeStatus('.$data->id.')','title'=>'Изменить статус']);
			            }else{
				            return Html::button('<i  class="fa fa-minus"></i>',['class' => 'btn btn-sm btn-danger', 'id'=>'status_'.$data->id, 'onclick' => 'changeStatus('.$data->id.')','title'=>'Изменить статус']);
			            }
		        },
	        ],
	        [
		        'attribute' => 'avatar',
		        'label' => 'Аватар',
		        'format' => 'raw',
		        'options' => ['width' => '70'],
		        'filter' => false,
		        'value' => function($data){
			        if($data->avatar != null || $data->avatar != '') {
				        return Html::img(Url::to('@frt_url/img/avatars/' . $data->avatar), [
					        'alt' => 'Аватар',
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
            // 'count_fm',
            // 'count_ft',
            // 'auth_key',
            // 'password_hash',

	        [
		        'class' => 'yii\grid\ActionColumn',
		        'contentOptions' => ['style' => 'width: 130px; max-width: 130px;'],
		        'template' => '<div class="btn-group">{view} {update}</div> {delete}',
		        'buttons' => [
			        'view' => function ($url, $model, $key) {
				        return Html::a(
					        '<i class="fa fa-eye"></i>',
					        $url,
					        [
						        'class' => 'btn btn-sm btn-primary',
						        'title' => 'Просмотр',
					        ]
				        );
			        },
			        'update' => function ($url, $model, $key) {
				        return Html::a(
					        '<i class="fa fa-edit"></i>',
					        $url,
					        [
						        'class' => 'btn btn-sm btn-success',
						        'title' => 'Изменить',
					        ]
				        );
			        },
			        'delete' => function ($url, $model, $key) {
				        return Html::a(
					        '<i class="fa fa-trash"></i>',
					        $url,
					        [
						        'class' => 'btn btn-sm btn-danger',
						        'title' => 'Удалить',
						        'data' => [
							        'confirm' => 'Вы действительно хотите удалить этого пользователя?',
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
