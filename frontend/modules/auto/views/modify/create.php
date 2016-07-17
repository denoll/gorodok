<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoModify */

$this->title = 'Create Auto Modify';
$this->params['breadcrumbs'][] = ['label' => 'Auto Modifies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-modify-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
