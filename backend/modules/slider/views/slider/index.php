<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\slider\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фото на главной';
$this->params['breadcrumbs'][] = $this->title;
$status = [
	['id' => '1', 'name' => 'Да'],
	['id' => '0', 'name' => 'Нет'],
];
?>
<div class="slider-main-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Добавить новое фото', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width: 90px; max-width: 90px;'],
				'template' => '{update} {delete}',
				'buttons' => [
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
									'confirm' => 'Вы действительно хотите это фото?',
									'method' => 'post',
								],
							]
						);
					},
				],
			],

			[
				'attribute' => 'status',
				'label' => 'Активно',
				'format' => 'raw',
				'filter' => \yii\helpers\ArrayHelper::map($status, 'id', 'name'),
				'options' => ['width' => '70'],
				'value' => function ($data) {
					if ($data->status == 1) {
						return Html::button('<i class="fa fa-check"></i>', ['class' => 'btn btn-sm btn-success', 'id' => 'status_' . $data->id, 'onclick' => 'changeStatus(' . $data->id . ')', 'title' => 'Изменить статус']);
					} else {
						return Html::button('<i  class="fa fa-minus"></i>', ['class' => 'btn btn-sm btn-danger', 'id' => 'status_' . $data->id, 'onclick' => 'changeStatus(' . $data->id . ')', 'title' => 'Изменить статус']);
					}
				},
			],
			[
				'attribute' => 'thumbnail',
				'label' => 'Фото',
				'format' => 'raw',
				'options' => ['width' => '60'],
				'filter' => false,
				'value' => function ($data) {
					if ($data->thumbnail != null || $data->thumbnail != '') {
						return Html::img(Url::to('@frt_url/img/slider/' . $data->thumbnail), [
							'alt' => 'Фото',
							'style' => 'width:31px;'
						]);
					} else {
						return Html::img(Url::to('@frt_url/img/avatars/avatar_128.png'), [
							'alt' => 'Аватар',
							'style' => 'width:31px;'
						]);
					}
				},
			],

			'user.username',
			'name',
			'description',
			[
				'attribute' => 'id',
				'options' => ['width' => '60'],
			],
			['class' => 'yii\grid\SerialColumn'],
		],
	]); ?>
</div>

<?php
$js = <<<JS
function changeStatus(id){
    var status = "#status_"+id;
    $.ajax({
        type: "post",
        url: "/slider/slider/change-status",
        data: "id=" + id,
        cache: true,
        dataType: "text",
        success: function (data) {
            if(data == '1'){
                $(status + ' i').removeClass("fa-minus");
                $(status + ' i').addClass("fa-check");
                $(status).removeClass('btn-danger');
                $(status).addClass('btn-success');
            }else{
                $(status + ' i').removeClass("fa-check");
                $(status + ' i').addClass("fa-minus");
                $(status).removeClass('btn-success');
                $(status).addClass('btn-danger');
            }
        }
    });
}
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
