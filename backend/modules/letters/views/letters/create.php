<?php

use yii\helpers\Html;
use app\modules\letters\Module;


/* @var $this yii\web\View */
/* @var $model common\models\Letters */

$this->title = 'Создать новость';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letters-create">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
