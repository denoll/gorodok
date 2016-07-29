<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\realty\models\SearchSale */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Объявления о продаже недвижимости';
$this->params[ 'breadcrumbs' ][] = $this->title;
?>
<div class="realty-sale-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Добавить новое объявление о продаже недвижимости', [ 'create' ], [ 'class' => 'btn btn-success' ]) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel'  => $searchModel,
		'columns'      => [
			[
				'class'          => 'yii\grid\ActionColumn',
				'contentOptions' => [ 'style' => 'width: 90px; max-width: 90px;' ],
				'template'       => '{update} {delete}',
				'buttons'        => [
					'update' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-edit"></i>',
							['/realty/sale/update', 'id'=>$model->id],
							[
								'class' => 'btn btn-sm btn-primary',
								'title' => 'Редактировать',
							]
						);
					},
					'delete' => function ($url, $model, $key) {
						return Html::a(
							'<i class="fa fa-trash"></i>',
							['/realty/sale/delete', 'id'=>$model->id],
							[
								'class' => 'btn btn-sm btn-danger',
								'title' => 'Удалить',
								'data'  => [
									'confirm' => 'Вы действительно хотите удалить это объявление?',
									'method'  => 'post',
								],
							]
						);
					},
				],
			],
			[
				'attribute' => 'status',
				'label'     => 'Статус',
				'format'    => 'raw',
				'filter'    => false, // \yii\helpers\ArrayHelper::map($status, 'id', 'name'),
				'options'   => [ 'width' => '70' ],
				'value'     => function ($data) {
					if ( $data[ 'status' ] == 1 ) {
						return Html::button('<i class="fa fa-check"></i>', [ 'class' => 'btn btn-sm btn-success', 'id' => 'status_' . $data[ 'id' ], 'onclick' => 'changeStatus(' . $data[ 'id' ] . ')', 'title' => 'Изменить статус' ]);
					} else {
						return Html::button('<i  class="fa fa-minus"></i>', [ 'class' => 'btn btn-sm btn-danger', 'id' => 'status_' . $data[ 'id' ], 'onclick' => 'changeStatus(' . $data[ 'id' ] . ')', 'title' => 'Изменить статус' ]);
					}
				},
			],
			[
				'attribute' => 'id',
				'label'     => '№ ',
				'filter'    => false,
				'options'   => [ 'width' => '70' ],
			],
			[
				'attribute' => 'category',
				'label'     => 'Категория',
				'format'    => 'raw',
				'filter'    => ArrayHelper::map(\common\models\realty\RealtyCat::find()->orderBy('root', 'lft')->all(), 'name', 'name'),
				'value'     => 'category',
				'options'   => [ 'width' => '170' ],
			],
			[
				'attribute'           => 'username',
				'value'               => 'username',
				'format'              => 'raw',
				'filterType'          => GridView::FILTER_SELECT2,
				'filter'              => ArrayHelper::map(\common\models\users\User::find()->all(), 'username', 'username'),
				'filterWidgetOptions' => [
					'pluginOptions' => [ 'allowClear' => true ],
				],
				'filterInputOptions'  => [ 'placeholder' => 'Пользователь ...' ],
			],
			'name',
			'cost',
			'created_at',
			// 'area_home',
			// 'area_land',
			// 'floor',
			// 'floor_home',
			// 'resell',
			// 'in_city',
			// 'type',
			// 'repair',
			// 'elec',
			// 'gas',
			// 'water',
			// 'heating',
			// 'tel_line',
			// 'internet',
			// 'distance',
			// 'main_img',
			// 'address',
			// 'description:ntext',
			// 'updated_at',
			// 'vip_date',
			// 'adv_date',
			// 'm_keyword',
			// 'm_description',
			// 'count_img',
		],
	]); ?>
</div>
<?php
$js = <<<JS
function changeStatus(id){
    var status = "#status_"+id;
    $.ajax({
        type: "post",
        url: "/realty/sale/change-status",
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
