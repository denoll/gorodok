<?php

	use yii\helpers\Html;


	/* @var $this yii\web\View */
	/* @var $model common\models\ForumTheme */

$this->title = 'Редактирование темы';
$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $name_cat, 'url' => ['category','id'=>$alias_cat]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['theme','id'=>$model['alias']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-theme-create">


	<?= $this->render('_form', [
		'model' => $model,
		'id_cat' => $id_cat,
		'alias_cat' => $alias_cat,
		'name_cat' => $name_cat,
	]) ?>

</div>
