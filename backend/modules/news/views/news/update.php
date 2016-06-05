<?php

use yii\helpers\Html;
use app\modules\news\Module;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Изменить новость: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="news-update">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
