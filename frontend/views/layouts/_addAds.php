<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 27.07.2016
 * Time: 11:14
 */

use yii\helpers\Html;
use \yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $user common\models\users\User */

?>
<?php Modal::begin([
	'id' => 'btn-advert',
	'size' => 'modal-lg',
	'header'       => Html::tag('h2', '<i>Подача объявления </i>'),
]); ?>
<div class="row">
	<div class="col-md-12">
		<div class="tag-box tag-box-v4 margin-bottom-10">
			<h2>Выберите категорию в которую Вы хотите подать объявление.</h2>
		</div>
		<section class="line-icon-page margin-bottom-40">
			<?= Html::a('<span class="item"><span class="icon-basket-loaded" aria-hidden="true"></span>товары</span>',
				['/goods/goods/create'],
				['class' => 'item-box']);
			?>
			<?= Html::a('<span class="item"><span class="icon-call-in" aria-hidden="true"></span>услуги</span>',
				['/service/service/create'],
				['class' => 'item-box']);
			?>
			<?= Html::a('<span class="item"><span class="icon-rocket" aria-hidden="true"></span>авто</span>',
				['/auto/item/create'],
				['class' => 'item-box']);
			?>
			<?= Html::a('<span class="item"><span class="icon-home" aria-hidden="true"></span>недвижимость продажа</span>',
				['/realty/sale/create'],
				['class' => 'item-box']);
			?>
			<?= Html::a('<span class="item"><span class="icon-calendar" aria-hidden="true"></span>недвижимость аренда</span>',
				['/realty/rent/create'],
				['class' => 'item-box']);
			?>
			<?= Html::a('<span class="item"><span class="icon-briefcase" aria-hidden="true"></span>вакансии</span>',
				['/jobs/vacancy/create'],
				['class' => 'item-box']);
			?>
			<?= Html::a('<span class="item"><span class="icon-users" aria-hidden="true"></span>резюме</span>',
				['/jobs/resume/create'],
				['class' => 'item-box']);
			?>
		</section>
	</div>
</div>
<?php Modal::end(); ?>
