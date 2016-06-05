<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\users\UserAccount */
/* @var $form yii\widgets\ActiveForm */
$this->params['left'] = true;
$paymentMethod = \common\widgets\Arrays::paymentMethods();
$methods = \yii\helpers\ArrayHelper::map($paymentMethod, 'id', 'name');
$user = Yii::$app->user->getIdentity();
$this->title = 'Пополнение баланса';
?>

<div class="user-account-form">

	<?php $form = ActiveForm::begin([
		'action' => $settings->form_action, // 'https://money.yandex.ru/eshop.xml',
		'method' => 'POST',
		'id' => 'payment_form',
		'options' => [
			'class' => '',
		],
	]); ?>

	<input type="hidden" name="shopId" value="<?= $settings->SHOP_ID ?>">
	<input type="hidden" name="scid" value="<?= $settings->SCID ?>">
	<input type="hidden" name="customerNumber" size="64" value="<?= $user->id ?>"><br><br>
	<input name="orderNumber" value="<?= $orderNumber ?>" type="hidden"/>
	<input name="cps_phone" value="<?= $user->tel ?>" type="hidden"/>
	<input name="cps_email" value="<?= $user->email ?>" type="hidden"/>
	<div class="row">
		<div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3 shadow-wrapper">
			<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
				<h1>Пополнение баланса</h1>
				<div class="form-group">
					<label class="control-label" for="paymentType">Выберите способ оплаты</label>
					<?= Html::dropDownList('paymentType', '', $methods, ['id' => 'paymentType', 'class' => 'form-control']) ?>
				</div>

				<label class="control-label" for="paymentType">Внесите сумму в рублях на которую хотите пополнить свой счет (руб.):</label>
				<div class="input-group">
					<?= Html::textInput('sum', 50, ['id' => 'sum', 'class' => 'form-control']) ?>
					<span class="input-group-btn">
							<?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary']) ?>
					</span>
				</div>

			</div>
		</div>
	</div>


	<?php ActiveForm::end(); ?>

</div>
