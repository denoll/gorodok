<?php
/**
 * Created by denoll.
 * User: denoll
 * Date: 16.08.2015
 * Time: 2:45
 */

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
$this->params['left'] = true;
$this->params['right'] = true;
$status = [
	'0' => 'Видно только мне и автору темы',
	'1' => 'Видно всем',
];
$checked_1 = $message->status == 1 ? 'checked' : '';
$checked_2 = $message->status == 0 ? 'checked' : '';

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $message->idCat->name, 'url' => ['category','id'=>$message['idCat']['alias']]];
$this->params['breadcrumbs'][] = ['label' => $message->idTheme->name, 'url' => ['theme','id'=>$message['idTheme']['alias']]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="update_message">
	<?php if (Yii::$app->user->isGuest) { ?>
		<h3>Зарегистрируйтесть чтобы оставлять сообщения на форуме !!!</h3>
	<?php } else { ?>
		<?php yii\widgets\Pjax::begin(['id' => 'update_message']) ?>
		<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
        <div class="radio_buttons">
            <div>
                <input type="radio" name="ForumMessage[status]" id="radio1" value="1" <?=$checked_1?> />
                <label for="radio1">Сообщение видно всем</label>
            </div>
            <div>
                <input type="radio" name="ForumMessage[status]" id="radio2" value="0" <?=$checked_2?> />
                <label for="radio2">Только мне и автору темы</label>
            </div>
        </div>
		<?= $form->field($message, 'message')->textarea([
			'placeholder'=>'Напишите свой ответ тут.',
			'wrap'=>'physical',
			'rows'=>6,
		])->label(false) ?>
		<div class="btn-group">
			<?= Html::submitButton('<i class="fa fa-check"></i> &nbsp;Сохранить изменения', ['class' => 'btn btn-primary', 'id' => 'btn_message']) ?>
		</div>
		<?php ActiveForm::end(); ?>
		<?php Pjax::end(); ?>
	<?php } ?>
</div>