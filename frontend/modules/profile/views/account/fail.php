<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 30.01.2016
 * Time: 23:06
 */

$this->params['left'] = true;
?>
<div class="container-fluid shadow-wrapper">
	<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
		<h1 style="text-align: center">Оплата по какой-то причине не прошла!</h1>
		<?= \yii\helpers\Html::a('Попробавать оплатить еще раз', ['/account/pay'], ['class' => 'btn-u btn-u-lg btn-block btn-brd']) ?>
		<small>
			<em>Попробуйте провести платеж еще раз.</em>
		</small>
	</div>
</div>


