<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoModels */

$this->title = 'Create Auto Models';
$this->params['breadcrumbs'][] = ['label' => 'Auto Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-models-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
