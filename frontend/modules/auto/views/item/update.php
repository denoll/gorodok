<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */

$this->title = 'Изменение объявления Авто№: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Все объявления Авто', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
