<?php

use common\widgets\DbBanner;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\MyNav;
use frontend\widgets\JobSearch;
//use common\models\Menu;

//$menu = new Menu();
//$menuItems = $menu->menuItems();

$menuItems = [
	['label' => 'Работа', 'url' => ['/jobs/resume/index'], 'options' => ['class' => 'main_menu_li'], 'items' => [
		['label' => 'Резюме', 'url' => ['/jobs/resume/index']],
		['label' => 'Вакансии', 'url' => ['/jobs/vacancy/index']],
	],],
	//['label' => 'Врачи', 'url' => ['/med/doctors/index'], 'options' => ['class' => 'main_menu_li']],
	['label' => 'Полезные адреса', 'url' => ['/firm/firm/index'], 'options' => ['class' => 'main_menu_li']],
	['label' => 'Товары', 'url' => ['/goods/goods/index'], 'options' => ['class' => 'main_menu_li']],
	['label' => 'Услуги', 'url' => ['/service/service/index'], 'options' => ['class' => 'main_menu_li'], 'items' => [
		['label' => 'Оказание услуг', 'url' => ['/service/service/index']],
		['label' => 'Получение услуг', 'url' => ['/service/set-service/index']],
	],],
	//['label' => 'Хобби', 'url' => ['/service/category/hobby'], 'options' => ['class' => 'main_menu_li']],
	['label' => 'Афиша', 'url' => ['/afisha/afisha/index'], 'options' => ['class' => 'main_menu_li']],
	//['label' => 'Коллективные письма', 'url' => ['/site/in-work'], 'options' => ['class' => 'main_menu_li']],
	['label' => 'Авто', 'url' => ['/auto/item/index'], 'options' => ['class' => 'main_menu_li']],
	['label' => 'Недвижимость', 'options' => ['class' => 'main_menu_li'], 'items' => [
		['label' => 'Продажа', 'url' => ['/realty/sale/index']],
		['label' => 'Аренда', 'url' => ['/realty/rent/index']],
	],],
	/*['label' => 'Контакты', 'options' => ['class' => 'main_menu_li'], 'items' => [
		['label' => 'На главную', 'url' => ['/site/index']],
		['label' => 'На главную', 'url' => ['/site/index']],
		['label' => 'На главную', 'url' => ['/site/index']],
	],],*/
];

$count = count($menuItems);
$li = (100 / $count) - 0.01;


?>
<style type="text/css">
	@media (min-width: 980px) {
		.main_menu {
			width: 100.7%;
		}

		.main_menu_li {
			width: <?= $li?>%;
		}

		li.main_menu_li a {
			text-align: center;
			padding: 8px 0px 8px 0px !important;
		}
	}
</style>
<div class="navbar navbar-default mega-menu" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header" style="margin: 15px 0px; width: 100%;">
			<div class="row">
				<div class="col-sm-2 side_left block-top">
					<a class="navbar-brand" href="/" style="margin: 0px; padding: 0px;">
						<?= Html::img(Url::to('@frt_url/img/logo_2.png'), ['id' => 'logo-header', 'style' => 'width:100%;', 'alt' => 'Logo']) ?>
					</a>
				</div>
				<div class="col-sm-7 side_left block-top">
					<?= DbBanner::widget(['key' => 'banners_all_pages_top_hover_menu']) ?>
				</div>
				<div class="col-sm-3 block-top">
					<?= Html::button('<span class="icon-like" aria-hidden="true"></span>&nbsp;&nbsp;Подать объявление',
						[
							'id'=>'btn-advert-button',
							'data-target' => '#btn-advert',
							'data-toggle' => 'modal',
							'class'=>'btn-sh cat-button hover-effect'
						]) ?>
				</div>
			</div>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="full-width-menu">Меню: </span>
                        <span class="icon-toggle">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </span>
			</button>
		</div>
	</div>


	<div class="navbar-collapse mega-menu navbar-responsive-collapse collapse in" role="navigation">
		<div class="container">
			<?php
			echo MyNav::widget([
				'options' => ['class' => 'nav navbar-nav main_menu'], //main_menu
				'items' => $menuItems,
			]);
			?>
		</div>
	</div>
</div>




