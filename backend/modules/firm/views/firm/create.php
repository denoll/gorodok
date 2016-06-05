<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\firm\Firm */

$this->title = 'Добавление новой фирмы';
$this->params['breadcrumbs'][] = ['label' => 'Фирмы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
