<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\firm\FirmCat */

$this->title = 'Создание категории фирм';
$this->params['breadcrumbs'][] = ['label' => 'Категории фирм', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
