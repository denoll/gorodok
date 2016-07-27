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
	'size' => 'modal-lg',
	'header'       => Html::tag('h3', '<i>Подача объявления </i>'),
	'toggleButton' => [
		'tag'   => 'button',
		'class' => 'btn-sh cat-button hover-effect',
		'label' => '<span class="icon-like" aria-hidden="true"></span>&nbsp;&nbsp;Подать объявление',
	],
]); ?>
<div class="row">
	<div class="container-fluid">
		<div class="tag-box tag-box-v4 margin-bottom-10">
			<h2 class="no-margin">Выберите категорию в которую Вы хотите подать объявление.</h2>
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
