<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Metatags */

$this->title = 'Create Metatags';
$this->params['breadcrumbs'][] = ['label' => 'Metatags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metatags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
