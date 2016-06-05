<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\text\Text */

$this->title = 'Изменение текстовой вставки: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Текстовые вставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
