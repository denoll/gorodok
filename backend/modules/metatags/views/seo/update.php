<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Metatags */

$this->title = 'Изменение метатегов на странице: ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Все метатеги', 'url' => ['index']];

?>
<div class="metatags-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
