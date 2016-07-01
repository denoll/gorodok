<?php

use yii\bootstrap\Html;
use app\widgets\DbText;

/* @var $this yii\web\View */
/* @var $model common\models\firm\Firm */
$user = Yii::$app->user->getIdentity();

if (!$model->isNewRecord) {
	$this->title = 'Изменение компании: ' . ' ' . $model->name;
	$this->params['breadcrumbs'][] = ['label' => 'Все фирмы', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
	$this->params['breadcrumbs'][] = 'Изменение';
} else {
	$model->name = !empty($user->company_name) ? $user->company_name : $user->username;
	$this->title = 'Добавление новой компании';
	$this->params['breadcrumbs'][] = ['label' => 'Фирмы', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="firm-update">

	<h1><?= Html::encode($this->title) ?></h1>
	<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
		<?= DbText::widget(['key' => 'registration_company_step_two']) ?>
	</div>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
