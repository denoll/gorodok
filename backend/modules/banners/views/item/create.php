<?php

/* @var $this yii\web\View */
/* @var $model common\models\banners\BannerItem */

$this->title = 'Создание нового рекламного баннера';
$this->params['breadcrumbs'][] = ['label' => 'Все рекламные баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-item-create">

	<?= $this->render('_form', [
		'model' => $model,
		'users' => $users,
		'advert' => $advert,
		'blocks' => $blocks,
	]) ?>

</div>
