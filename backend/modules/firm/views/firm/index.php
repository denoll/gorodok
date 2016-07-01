<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\users\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\firm\FirmSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фирмы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-index">
	<p>
		<?= Html::a('<i class="fa-fw fa fa-plus" style="margin-right: 12px;"></i>Добавить новую фирму', ['create'], ['class' => 'btn btn-success', 'style' => 'width: 250px; font-size: 0.9em; color: #fff; padding: 5px 7px 5px 7px; text-align:center']) ?>
		<?= Html::a('<i class="fa-fw fa fa-download" style="margin-right: 12px;"></i>Импорт фирм', ['/firm/import/import-firm'], ['class' => 'btn btn-primary', 'style' => 'width: 250px; font-size: 0.9em; color: #fff; padding: 5px 7px 5px 7px; text-align:center']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'class' => 'yii\grid\ActionColumn',
			],
			'id',
			[
				'attribute' => 'id_cat',
				'filter' => ArrayHelper::map(\common\models\firm\FirmCat::find()->asArray()->all(), 'id','name'),
				'value' => 'cat.name',
			],
			[
				'attribute' => 'id_user',
				'filter' => ArrayHelper::map(User::find()->select(['id', 'username', 'company', 'status'])->where(['status'=>User::STATUS_ACTIVE, 'company'=>1])->asArray()->all(), 'id','username'),
				'value' => 'users.username',
			],
			'status:boolean',
			'show_requisites:boolean',
			'name',
			'tel',
			'email:email',
			'site',
			[
				'attribute' => 'logo',
				'format' => 'raw',
				'options' => ['width' => '60'],
				'filter' => false,
				'value' => function ($data) {
					if (!empty($data['logo'])) {
						return Html::img($data['base_url'] .'/'.$data['logo'], [
							'alt' => 'Фото',
							'style' => 'width:60px;'
						]);
					} else {
						return Html::img(Url::to('@frt_url/img/no-img.png'), [
							'alt' => 'Фото',
							'style' => 'width:60px;'
						]);
					}
				},
			],
			'address',
			// 'description:ntext',
			// 'created_at',
			// 'updated_at',
			// 'mk',
			// 'md',


		],
	]); ?>
</div>
