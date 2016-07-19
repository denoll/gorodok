<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\auto\AutoBrands */

$this->title = 'Create Auto Brands';
$this->params['breadcrumbs'][] = ['label' => 'Auto Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auto-brands-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
