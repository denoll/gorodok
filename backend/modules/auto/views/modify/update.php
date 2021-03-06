<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoModify */

$this->title = 'Update Auto Modify: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auto Modifies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auto-modify-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
