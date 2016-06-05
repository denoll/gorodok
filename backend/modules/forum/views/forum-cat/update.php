<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Forums */

$this->title = 'Редактировать категорию форума: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'редактировать';
?>
<div class="forums-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
