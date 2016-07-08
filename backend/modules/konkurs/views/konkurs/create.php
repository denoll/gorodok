<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\konkurs\Konkurs */

$this->title = 'Создание нового конкурса';
$this->params['breadcrumbs'][] = ['label' => 'Все конкурсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="konkurs-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
