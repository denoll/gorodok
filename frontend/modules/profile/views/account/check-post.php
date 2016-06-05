<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 03.02.2016
 * Time: 14:35
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<?php $form = ActiveForm::begin([
	'action' => 'check-order', // 'https://money.yandex.ru/eshop.xml',
	'method' => 'POST',
	'id' => 'check-post',
	'options' => [
		'class' => '',
	],
]); ?>
<pre>
    <?php print_r(Yii::$app->request->post()) ?>
    </pre>

<input  name="requestDatetime" value="2011-05-04T20:38:00.000+04:00" type="hidden"/>
<input name="action" value="checkOrder" type="hidden"/>
<input name="md5" value="EDA83A42747F80A000577219601CB932" type="hidden"/>
<input name="shopId" value="114898" type="hidden"/>
<input name="shopArticleId" value="234234" type="hidden"/>
<input name="invoiceId" value="2342342342" type="hidden"/>
<input name="customerNumber" size="64" value="4" type="hidden"/>
<input name="orderCreatedDatetime" value="2011-05-04T20:38:00.000+04:00" type="hidden"/>
<input name="orderSumAmount" value="100" type="hidden"/>
<input name="orderSumCurrencyPaycash" value="643" type="hidden"/>
<input name="orderSumBankPaycash" value="1001" type="hidden"/>
<input name="shopSumAmount" value="100" type="hidden"/>
<input name="shopSumCurrencyPaycash" value="643" type="hidden"/>
<input name="shopSumBankPaycash" value="1001" type="hidden"/>
<input name="paymentPayerCode" value="45343453242" type="hidden"/>
<input name="paymentType" value="AC" type="hidden"/>
<input name="cps_email" value="odanic@yandex.ru" type="hidden"/>

<br>

<div class="form-group">
	<?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
