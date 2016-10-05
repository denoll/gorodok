<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.09.2015
 * Time: 1:17
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

	$menuItems = [
		['label' => '<i class="fa fa-dashboard"></i> <span class="nav-label">Панель</span>', 'url' => [Url::home() . 'site/index']],
		['label' => '<i class="fa fa-cubes"></i> <span class="nav-label">Меню</span>', 'items' => [
			['label' => '<i class="fa fa-cubes"></i> <span class="nav-label">Меню</span>', 'url' => [Url::home() . 'menu/menu-list/index']],
		]],
	];
?>
<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                       <span class="clear">
	                       <span class="block m-t-xs"> <strong class="font-bold">Панель управления</strong></span>
                       </span>
					</a>
				</div>
				<div class="logo-element">
					IN+
				</div>
			</li>
			<li>
				<a href="<?=Url::home()?>"><i class="fa fa-dashboard"></i><span class="nav-label">Панель</span></a>
			</li>
			<li>
				<?= Html::a('<i class="fa fa-money"></i><span class="nav-label"> Платежи</span>',['/account/account/index']) ?>
			</li>
			<li>
				<a href="#"><i class="fa fa-pied-piper"></i><span class="nav-label"> Реклама</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-object-group"></i> Баннеры',['/banners/item/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-trello"></i> Блоки для баннеров',['/banners/banner/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-university"></i> Рекламные компании',['/banners/advert/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-map"></i><span class="nav-label"> Афиша</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Афиша категории',['/afisha/afisha-category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-university"></i> Места мероприятий',['/afisha/place/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-map"></i> Афиша',['/afisha/afisha/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-envelope-o"></i><span class="nav-label"> Колл. письма</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории писем',['/letters/letters-category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-envelope-o"></i> Колл. письма',['/letters/letters/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-hand-peace-o"></i><span class="nav-label"> Конкурсы</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории',['/konkurs/konkurs-cat/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-hand-peace-o"></i> Конкурсы',['/konkurs/konkurs/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-puzzle-piece"></i> Элементы',['/konkurs/item/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-newspaper-o"></i><span class="nav-label">Новости</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории новостей',['/news/news-category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-newspaper-o"></i> Новости',['/news/news/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-file-text"></i><span class="nav-label">Статьи</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории статей',['/page/page-category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-file-text"></i> Статьи',['/page/page/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-bank"></i><span class="nav-label">Фирмы</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории фирм',['/firm/firm-cat/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-bank"></i> Фирмы',['/firm/firm/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-flag"></i><span class="nav-label">Форум</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-share-alt"></i> Форумы',['/forum/forum/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории форума',['/forum/forum-cat/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-flag"></i> Темы и сообщения',['/forum/forum-theme/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-optin-monster"></i><span class="nav-label">Работа</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории',['/jobs/category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-support"></i> Резюме',['/jobs/resume/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-subway"></i> Вакансии',['/jobs/vacancy/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-ambulance"></i><span class="nav-label">Врачи</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-medkit"></i> Специальности',['/med/spec/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-user-md"></i> Врачи',['/med/doctors/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-car"></i><span class="nav-label"> Авто</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-car"></i> Авто объявления',['/auto/item/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-flag"></i> Авто бренды',['/auto/brands/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-flag-checkered"></i> Авто модели',['/auto/models/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-flag-o"></i> Авто модификации',['/auto/modify/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-shopping-cart"></i><span class="nav-label">Товары</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории товаров',['/goods/goods-category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-shopping-cart"></i> Товары',['/goods/goods/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-wrench"></i><span class="nav-label">Услуги</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории услуг',['/service/service-category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-wrench"></i> Услуги',['/service/service/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-building"></i><span class="nav-label">Недвижимость</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Категории',['/realty/category/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-building"></i> продажа',['/realty/sale/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-building"></i> аренда',['/realty/rent/index']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-diamond"></i><span class="nav-label">Разное</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-camera"></i> Фото на главной',['/slider/slider/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-font"></i> Текстовые вставки',['/text/text/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-edge"></i> Кэш',['/cache/cache/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-cubes"></i> Метатеги',['/metatags/seo/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-cubes"></i> Простые меню',['/menu/menu-list/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-cubes"></i> Меню',['/mainmenu/default/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-cubes"></i> Расширения',['/mainmenu/extensions/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-map"></i> Sitemap static',['/static-sitemap/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-map"></i> Расписание',['/schedule/default/train']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-users"></i><span class="nav-label">Пользователи</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-users"></i> Пользователи',['/users/user/index']) ?></li>
					<li><?= Html::a('<i class="fa fa-key"></i> Права',['/admin/rbac']) ?></li>
					<li><?= Html::a('<i class="fa fa-legal"></i> Роли',['/admin/rbac/role']) ?></li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-cubes"></i><span class="nav-label">Простые меню</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><?= Html::a('<i class="fa fa-cubes"></i> Простые меню',['/menu/menu-list/index']) ?></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
