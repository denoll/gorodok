<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 30.05.2015
 * Time: 2:16
 */

namespace frontend\widgets;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\bootstrap\Widget;
use common\models\users\User;
use frontend\widgets\Avatar;
use frontend\widgets\Balance;

class ProfileLeftSidebar extends Widget
{
	public $activeElement;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{


	}

	public function run()
	{
		$user = Yii::$app->user->getIdentity();
		switch ($this->activeElement) {
			case 0:
				$a_0 = 'active';
				break;
			case 1:
				$a_1 = 'active';
				break;
			case 2:
				$a_2 = 'active';
				break;
			case 3:
				$a_3 = 'active';
				break;
			case 4:
				$a_4 = 'active';
				break;
			case 5:
				$a_5 = 'active';
				break;
			case 6:
				$a_6 = 'active';
				break;
			case 7:
				$a_7 = 'active';
				break;
			case 8:
				$a_8 = 'active';
				break;
			case 9:
				$a_9 = 'active';
				break;
			case 10:
				$a_10 = 'active';
				break;
			case 11:
				$a_11 = 'active';
				break;
			case 12:
				$a_12 = 'active';
				break;
		}

		echo '<div class="profile_avatar">';
		echo '<div class="avatar thumbnail" style="position: relative; margin: 5px 0px;">';
		echo Avatar::init('100%');
		if (User::isCompany()) {
			echo Html::a('редактировать логотип', ['/profile/change-avatar'], ['class' => 'btn btn-xs btn-default', 'style' => 'position: absolute; bottom: 5px; left:5px; z-index: 2;']);
		} else {
			echo Html::a('редактировать аватар', ['/profile/change-avatar'], ['class' => 'btn btn-xs btn-default', 'style' => 'position: absolute; bottom: 5px; left:5px; z-index: 2;']);
		}

		echo '</div>';
		echo '</div>';

		Balance::init();

		echo '<div class="">';
		echo '<ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-1">';
		echo '<li class="list-group-item ' . $a_0 . '">';
		echo '<a href="' . Url::Home() . 'account/index"><i class="fa fa-ruble"></i>&nbsp;&nbsp;Взаиморасчеты </a>';
		echo '</li>';

		if (User::isCompany()) {
			echo '<li class="list-group-item ' . $a_1 . '">';
			echo '<a href="' . Url::Home() . 'profile/index"><i class="fa fa-user"></i>&nbsp;&nbsp;Профиль</a>';
			echo '</li>';
			echo '<li class="list-group-item ' . $a_2 . '">';
			echo '<a href="' . Url::Home() . 'profile/company"><i class="fa fa-bank"></i>&nbsp;&nbsp;Данные компании</a>';
			echo '</li>';
			echo '<li class="list-group-item ' . $a_3 . '">';
			echo '<a href="' . Url::Home() . 'jobs/vacancy/my-vacancy"><i class="fa  fa-suitcase "></i>&nbsp;&nbsp;Вакансии компании</a>';
			echo '</li>';
		} else {
			echo '<li class="list-group-item ' . $a_1 . '">';
			echo '<a href="' . Url::Home() . 'profile/index"><i class="fa fa-user"></i>&nbsp;&nbsp;Мой профиль</a>';
			echo '</li>';
			echo '<li class="list-group-item ' . $a_4 . '">';
			echo '<a href="' . Url::Home() . 'jobs/job-profile/index"><i class="fa fa-graduation-cap"></i>&nbsp;&nbsp;Расширенные сведения о себе</a>';
			echo '</li>';
			echo '<li class="list-group-item ' . $a_5 . '">';
			echo '<a href="' . Url::Home() . 'jobs/resume/my-resume"><i class="fa fa-inbox"></i>&nbsp;&nbsp;Мои резюме</a>';
			echo '</li>';
		}
		if ($user->doctor) {
			echo '<li class="list-group-item ' . $a_6 . '">';
			echo '<a href="' . Url::Home() . 'med/doctors/update"><i class="fa fa-user-md"></i>&nbsp;&nbsp;Мои мед. данные</a>';
			echo '</li>';
		}
		echo '<li class="list-group-item ' . $a_7 . '">';
		echo '<a href="' . Url::Home() . 'letters/letters/my-letters"><i class="fa fa-envelope-o "></i>&nbsp;&nbsp;Мои письма</a>';
		echo '</li>';
		echo '<li class="list-group-item ' . $a_8 . '">';
		echo '<a href="' . Url::Home() . 'goods/my-ads"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Мои объявления о товарах</a>';
		echo '</li>';
		echo '<li class="list-group-item ' . $a_9 . '">';
		echo '<a href="' . Url::Home() . 'service/my-ads"><i class="fa fa-wrench"></i>&nbsp;&nbsp;Мои объявления об услугах</a>';
		echo '</li>';
		echo '<li class="list-group-item ' . $a_10 . '">';
		echo '<a href="' . Url::Home() . 'realty/sale/my-ads"><i class="fa fa-building"></i>&nbsp;&nbsp;Мои объявления о продаже недвижимости</a>';
		echo '</li>';
		echo '<li class="list-group-item ' . $a_11 . '">';
		echo '<a href="' . Url::Home() . 'realty/rent/my-ads"><i class="fa fa-building"></i>&nbsp;&nbsp;Мои объявления об аренде недвижимости</a>';
		echo '</li>';
		//echo '<li class="list-group-item ' . $a_12 . '">';
		//echo '<a href="' . Url::Home() . 'auto/my-ads"><i class="fa fa-car"></i>&nbsp;&nbsp;Мои объявления об авто</a>';
		//echo '</li>';


		echo '</ul>';
		echo '</div>';
	}


}

?>
