<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Extensions */

$this->title = 'Изменить расширение: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Расширения', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="extensions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
