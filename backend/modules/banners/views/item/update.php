<?php

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */

$this->title = 'Редактирование рекламного баннера: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Все рекламные баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование баннера';

?>
<div class="banner-item-update">
	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
		'advert' => $advert,
		'blocks' => $blocks,
	]) ?>
</div>
