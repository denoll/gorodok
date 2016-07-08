<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */
/* @var $users common\models\users\User */

$this->title = 'Изменение конкурса: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="konkurs-update">

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
