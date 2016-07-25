<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\auto\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->params['left'] = true;
$this->params['right'] = true;

$this->title = 'Объявления авто';
$this->params['breadcrumbs'][] = $this->title;

$m_kw = 'продать автомобиль в тынде, купить автомобиль в тынде, автомобили в тынде, каталог автомобилей в тынде, продажа автомобилей в тынде';
$m_d = 'Объявления о продеже и покупке автомобилей в Тынде. Здесь Вы можете подать свое объявление о продаже или покупке автомобиля в городе Тынада.';

if (!empty($m_d)) {
	$this->registerMetaTag(['content' => Html::encode($m_d), 'name' => 'description']);
}
if (!empty($m_kw)) {
	$this->registerMetaTag(['content' => Html::encode($m_kw), 'name' => 'keywords']);
}

?>
<div class="auto-item-index">

	<h1 class="header-title"><?= Html::encode($this->title) ?></h1>
	
	<?php echo $this->render('_search', [
			'model' => $searchModel,
		]);?>
	<?php if ($items) { ?>
		<?= ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_item',
			'layout' => '<div class="sorter-block"><i class="small-text">Сортировать:</i> {sorter} {pager}</div> {items} {pager}',
		]); ?>
	<?php } else { ?>
		<div class="alert alert-success fade in">
			<strong>Ничего не найдено!</strong>
		</div>
	<?php } ?>
</div>
