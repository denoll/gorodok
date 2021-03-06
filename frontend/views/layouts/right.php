<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 06.08.2015
 * Time: 12:26
 */
use yii\helpers\Url;
use common\widgets\DbBanner;
use frontend\widgets\ProfileLeftSidebar;

$show = false;

$path = Url::current();

if (!stristr($path, 'site')) {
	echo \frontend\widgets\LinkPage::widget([
		'text' => '<i class="fa fa-smile-o"></i>&nbsp;&nbsp;&nbsp;Улыбнись',
		'url' => ['/news/news/index', 'cat'=>'ulybnis'],
		'options' => [
			'class' => 'btn-u header-link',
			'style' => 'margin-top: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
		],
	]);
	echo \frontend\widgets\LinkPage::widget([
		'text' => '<i class="fa fa-train"></i>&nbsp;&nbsp;&nbsp;Расписание поездов',
		'url' => ['/schedule/default/train'],
		'options' => [
			'class' => 'btn-u header-link',
			'style' => 'margin-top: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
		],
	]);
	echo \frontend\widgets\LinkPage::widget([
		'text' => '<i class="fa fa-train"></i>&nbsp;&nbsp;&nbsp;Расписание электричек',
		'url' => ['/schedule/default/suburban'],
		'options' => [
			'class' => 'btn-u header-link',
			'style' => 'margin-top: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
		],
	]);
	echo \frontend\widgets\LinkPage::widget([
		'text' => '<i class="fa fa-plane"></i>&nbsp;&nbsp;&nbsp;Авиа расписание',
		'url' => ['/page/page/view', 'cat' => 'poleznaa-informacia','id'=>'raspisanie-samoletov'],
		'options' => [
			'class' => 'btn-u header-link',
			'style' => 'margin-top: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
		],
	]);
	echo \frontend\widgets\LinkPage::widget([
		'text' => '<i class="fa fa-bus"></i>&nbsp;&nbsp;&nbsp;Расписание автобусов',
		'url' => ['/page/page/view', 'cat' => 'poleznaa-informacia','id'=>'raspisanie-avtobusov'],
		'options' => [
			'class' => 'btn-u header-link',
			'style' => 'margin-top: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
		],
	]);
	echo \frontend\widgets\LinkPage::widget([
		'text' => '<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;&nbsp;Что улучшить в городе?',
		'url' => ['/letters/letters/index'],
		'options' => [
			'class' => 'btn-u header-link',
			'style' => 'margin-top: 10px; padding: 10px 15px; width: 100%; font-size: 1.2em;'
		],
	]);
	echo \frontend\widgets\NewsSidebarWidget::widget();
	echo \frontend\widgets\AfishaSidebarWidget::widget();
	echo \frontend\widgets\LettersSidebarWidget::widget();

	if (stristr($path, '/profile/') || stristr($path, '/jobs/') || stristr($path, '/account/')) {

		if (stristr($path, 'account/')) {

		}
		if (stristr($path, 'profile/index')) {

		}
		if (stristr($path, 'profile/company')) {

		}
		if (stristr($path, 'jobs/job-profile/index') || stristr($path, 'jobs/index') || stristr($path, 'jobs/edu') || stristr($path, 'jobs/exp')) {

		}
		if (stristr($path, 'jobs/resume/create') || stristr($path, 'jobs/resume/update') || stristr($path, 'jobs/resume/my-resume')) {

		}
		if (stristr($path, 'jobs/vacancy/create') || stristr($path, 'jobs/vacancy/update') || stristr($path, 'jobs/vacancy/my-vacancy')) {

		}
		if (stristr($path, 'jobs/resume/index') || stristr($path, 'jobs/resume/view')) {

		}
		if (stristr($path, 'jobs/vacancy/index') || stristr($path, 'jobs/vacancy/view')) {

		}
		//echo NewsSidebarWidget::init();
	}
	if (stristr($path, '/afisha')) {
		echo DbBanner::widget(['key' => 'right_side_afisha_small']);
	}
	if (stristr($path, '/med/doctors')) {
		if (stristr($path, '/med/doctors/index') || stristr($path, '/med/doctors/view')) {

		}
		if (stristr($path, '/med/doctors/update') || stristr($path, '/med/doctors/create') || stristr($path, '/med/doctors/my-serv')) {

		}
	}
	if (stristr($path, '/tags/')) {

	}


	if (stristr($path, '/goods/index') || stristr($path, '/goods/view')) {
		echo DbBanner::widget(['key' => 'right_side_tovari_small']);
	}

	if (stristr($path, '/service') || stristr($path, '/set-service')) {
		if (stristr($path, '/service/update') || stristr($path, '/service/create') || stristr($path, '/service/my-ads')) {
			echo ProfileLeftSidebar::showSidebar(9);
		}
		if (stristr($path, '/service')) {
			echo DbBanner::widget(['key' => 'right_side_uslygi_small']);
		}
		if (stristr($path, '/set-service')) {
			echo DbBanner::widget(['key' => 'right_side_uslygi_small']);
		}
	}

	if (stristr($path, '/realty')) {
		if (stristr($path, '/realty/sale')) {
			echo DbBanner::widget(['key' => 'right_side_nedvigimosproda_small']);
		}
		if (stristr($path, '/realty/rent')) {
			echo DbBanner::widget(['key' => 'right_side_nedvigimosarend_small']);
		}
	}

	if (stristr($path, '/news')) {
		echo DbBanner::widget(['key' => 'right_side_novosti_small']);
	}

	$show = true;

}
