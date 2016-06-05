<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\firm\FirmCat */

$this->title = 'Редактирование категории: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории фирм', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="firm-cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
