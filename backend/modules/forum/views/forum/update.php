<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Forums */

$this->title = 'Редактировать форум: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'форумы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'редактировать';
?>
<div class="forums-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
