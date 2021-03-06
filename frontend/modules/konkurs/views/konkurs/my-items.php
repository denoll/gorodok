<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 11.07.2016
 * Time: 2:54
 */


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->params['left'] = true;
$this->params['right'] = true;

Yii::$app->session->remove('id_konkurs');
Yii::$app->session->set('id_konkurs', $model->id);

$this->title = 'Конкурс: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];
if(!empty($model->cat)){
	$this->params['breadcrumbs'][] = ['label' => $model->cat->name, 'url' => ['/konkurs/konkurs/index', 'cat'=>$model->cat->slug]];
}
$this->params['breadcrumbs'][] = $this->title;
?>
	<div class="konkurs-view">
		<div class="row" style="padding-top: 5px;">
			<div class="container-fluid">
				<div class="tag-box tag-box-v4 no-margin">
					<h1 class="no-margin"><?= Html::encode($model['title']) ?></h1>
					<?= $model['description'] ?><br>
					<?= Html::a('Добавить новый элемент в конкурс',['/konkurs/item/create'],['class'=>'btn-u btn-block']); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<?= \yii\widgets\ListView::widget([
				'dataProvider' => $dataProvider,
				'itemView' => '_itemMyItem',
				'layout' => '<div class="col-md-12"><div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {pager}</div> </div> {items} <div class="col-md-12">{pager}</div>',
			]); ?>
		</div>
	</div>
<?php
$this->registerJsFile('/js/jquery.matchHeight.min.js',[
	'depends' => [
		\yii\web\JqueryAsset::className()
	],
]);

$js = <<<JS
	//$(document).ready(function(){
		$(function() {
			$('.for-one-height').matchHeight();
		});
	//});
JS;
$this->registerJS($js, \yii\web\View::POS_END);

?>