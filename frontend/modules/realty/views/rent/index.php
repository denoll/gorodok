<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\goods\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$ses = Yii::$app->session;
$ses->open();
$cur_cat = $ses->get('current_cat');
$parent_cat = $ses->get('parent_cat');
$first_child = $ses->get('first_child');
$ses->close();
$this->title = !empty($cur_cat) ? $cur_cat[ 'name' ] : 'Объявления об аренде недвижимости';
$this->params[ 'left' ] = true;
$this->params[ 'right' ] = true;

$seo = Yii::$app->seo->getByKey('realty_rent');
if ( !empty($cur_cat) ) {
	$this->params[ 'breadcrumbs' ][] = [ 'label' => 'Объявления об аренде недвижимости', 'url' => [ 'index' ] ];
	$m_kw = $cur_cat[ 'm_keyword' ] . ', ' . $seo->kw;
	$m_d = $cur_cat[ 'm_description' ] . '. ' . $seo->desc;
} else {
	$m_kw = $seo->kw;
	$m_d = $seo->desc;
}

if ( !empty($parent_cat) ) {
	foreach ( $parent_cat as $item ) {
		$this->params[ 'breadcrumbs' ][] = [ 'label' => $item[ 'name' ], 'url' => [ 'index', 'cat' => $item[ 'alias' ] ] ];
	}
}
$this->params[ 'breadcrumbs' ][] = $this->title;
if ( !empty($m_d) ) {
	$this->registerMetaTag([ 'content' => Html::encode($m_d), 'name' => 'description' ]);
}
if ( !empty($m_kw) ) {
	$this->registerMetaTag([ 'content' => Html::encode($m_kw), 'name' => 'keywords' ]);
}

?>
<style type="text/css">
	.help-block {
		margin: 0px !important;
	}

	.form-control {
		height: 35px;
	}
</style>
<div class="goods-index">
	<?= $this->render('_category', [
		'cat'         => $cat,
		'cur_cat'     => $cur_cat,
		'first_child' => $first_child,
	]); ?>

	<?php if ( $items ) { ?>
		<?php echo $this->render('_search', [
			'model'       => $searchModel,
			'cur_cat'     => $cur_cat, 400,
			'first_child' => $first_child,
		]); ?>
		<?= ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView'     => '_item',
			'layout'       => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {summary} {pager}</div> {items} {pager}',
		]); ?>
	<?php } else { ?>
		<div class="alert alert-success fade in">
			<strong>Ничего не найдено!</strong>
		</div>
	<?php } ?>

</div>

