<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */

$this->title = 'Update Auto Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Auto Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auto-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
