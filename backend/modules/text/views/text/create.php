<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\text\Text */

$this->title = 'Создание текстовой вставки';
$this->params['breadcrumbs'][] = ['label' => 'Текстовые вставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
