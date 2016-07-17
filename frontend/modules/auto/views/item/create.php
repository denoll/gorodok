<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoItem */

$this->title = 'Create Auto Item';
$this->params['breadcrumbs'][] = ['label' => 'Auto Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
