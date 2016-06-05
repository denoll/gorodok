<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use denoll\editor\CKEditor;
use common\models\ForumTheme;
use common\models\ForumCat;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\ForumMessage */
/* @var $form yii\widgets\ActiveForm */

	$status = [
		'0' => 'Видно только админу',
		'1' => 'Видно всем',
		'2' => 'Видно только автору',
	];

?>

<div class="forum-message-form">


    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'status')->radioList($status, [
	    'inline' => false,
    ]); ?>

	<?= $form->field($model, 'message')->widget(CKEditor::className(), [
		'options' => ['rows' => 6],
		'preset' => 'standart',
	]) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
