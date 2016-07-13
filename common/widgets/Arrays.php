<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 24.10.2015
 * Time: 4:55
 */

namespace common\widgets;

use common\models\goods\GoodsCat;
use common\models\jobs\JobCategory;
use common\models\jobs\JobCatRez;
use common\models\jobs\JobCatVac;
use common\models\med\Spec;
use common\models\users\User;
use yii\helpers\ArrayHelper;

class Arrays
{
	const IMG_COUNT = 10;
	const IMG_MAX_SIZE = 629146; // = (1024 * 1024 * 0.6); // 0.6MB
	const IMG_MAX_HEIGHT = 1024;
	const IMG_MAX_WIDTH = 1280;

	const IMG_SIZE_HEIGHT = 200;
	const IMG_SIZE_WIDTH = 200;

	const CASH_TIME = 300; //в секундах 60*60 = 3600 = 1 час  60*60*12 = 43200 = 12 час


	public static function comp()
	{
		return [
			['id' => '0', 'name' => 'частное лицо'],
			['id' => '1', 'name' => 'компания'],
		];
	}

	public static function getConst()
	{
		return [
			'vip' => 7,
		];
	}

	public static function PAYMENTS()
	{
		return [
			'res_vip_pay' => 100,
			'res_up_pay' => 30,
			'vac_vip_pay' => 100,
			'vac_up_pay' => 30,
			'goods_vip_pay' => 100,
			'goods_up_pay' => 30,
			'service_vip_pay' => 100,
			'service_up_pay' => 30,
			'realty_vip_pay' => 100,
			'realty_up_pay' => 30,
		];
	}

	public static function paymentMethods()
	{
		return [
			//['id' => 'AC', 'name' => 'Оплата с банковской карты.'],
			['id' => 'PC', 'name' => 'Со счета в Яндекс Деньгах.'],
			['id' => 'GP', 'name' => 'Наличными в салонах связи или через термирналы.'],
			['id' => 'MC', 'name' => 'Платеж со счета мобильного телефона.'],
			['id' => 'WM', 'name' => 'Оплата из кошелька в системе WebMoney.'],
			['id' => 'QW', 'name' => 'Оплата через QIWI Wallet.'],
			['id' => 'SB', 'name' => 'Оплата через Сбербанк: оплата по SMS или Сбербанк Онлайн.'],
			['id' => 'AB', 'name' => 'Оплата через Альфа-Клик.'],
			['id' => 'MA', 'name' => 'Оплата через MasterPass.'],
			['id' => 'PB', 'name' => 'Оплата через Промсвязьбанк.'],
			['id' => 'KV', 'name' => 'Оплата через КупиВкредит (Тинькофф Банк).'],
		];
	}

	public static function getPaymentMethod($id)
	{
		$res = self::paymentMethods();
		$res = ArrayHelper::map($res, 'id', 'name');
		return $res[$id];
	}

	public static function adsStatus(){
		return [
			'0' => 'Сейчас объявление скрыто.',
			'1' => 'Сейчас объявление видно всем.',
		];
	}

	public static function getAdsStatus($id)
	{
		$status = static::adsStatus();
		return $status[$id];
	}

	public static function reciving()
	{
		return [
			['id' => '0', 'name' => 'на дому и в клинике'],
			['id' => '1', 'name' => 'на дому'],
			['id' => '2', 'name' => 'в клинике'],
		];
	}

	public static function letterStage()
	{
		return [
			['id' => '0', 'name' => 'Сбор подписей'],
			['id' => '1', 'name' => 'Передано, ждем ответ'],
			['id' => '2', 'name' => 'Ответ получен'],
		];
	}

	public static function getLetterStage($stage)
	{
		$arr = self::letterStage();
		return $arr[$stage]['name'];
	}

	public static function forumThemeStatus($frontend = false)
	{
		if ($frontend) {
			$arr = [
				'1' => 'Открыта',
				'2' => 'Закрыта',
			];
		} else {
			$arr = [
				'0' => 'Не видна',
				'1' => 'Открыта',
				'2' => 'Закрыта',
			];
		}
		return $arr;
	}

	public static function getForumThemeStatus($status)
	{
		if ($status == '1') {
			return 'Открыта';
		} elseif ($status == '2') {
			return 'Закрыта';
		}
	}

	public static function getReciving($id)
	{
		$rec = self::reciving();
		return $rec[$id]['name'];
	}

	//Пользователи
	public static function getAllUsers()
	{
		return User::find()->asArray()->all();
	}

	// Товары
	public static function getGoodsCat()
	{
		return GoodsCat::find()->asArray()->where(['active' => 1, 'visible' => 1])->all();
	}


	// Врачи
	public static function medSpec()
	{
		$spec = Spec::find()->asArray()->all();
		if ($spec) {
			return $spec;
		} else {
			return false;
		}
	}

	public static function getMedSpec($id)
	{
		$spec = Spec::find()->where(['id' => $id])->asArray()->one();
		if ($spec) {
			return $spec['name'];
		} else {
			return false;
		}
	}

	public static function getMedCat()
	{
		return Spec::find()->asArray()->all();
	}

	// Работа
	public static function getJobCatTree($id = null)
	{
		if ($id === null) {
			$model = JobCategory::find()->asArray()->where(['status' => 1])->all();
			foreach ($model as $item) {
				$arr[$item['parent']][$item['id']] = $item;
			}
			return $arr;
		} else {
			return JobCategory::find()->asArray()->where(['status' => 1, 'id' => $id])->one();
		}

	}

	public static function getJobCat()
	{
		return JobCategory::find()->asArray()->where(['status' => 1])->all();
	}

	public static function getJobCatBiId($id)
	{
		return JobCategory::find()->asArray()->where(['id' => $id, 'status' => 1])->one();
	}

	public static function getResumeCat($res)
	{
		$_jcr = JobCatRez::find()->where(['id_res' => $res])->asArray()->all();
		foreach ($_jcr as $item) {
			$jcr[] = $item['id_cat'];
		}
		if (is_array($jcr)) {
			$jc = JobCategory::find()->where('id IN (' . implode(',', $jcr) . ') ')->asArray()->all();
			return $jc;
		} else return false;
	}

	public static function getVacanyCat($vac)
	{
		$_jcv = JobCatVac::find()->where(['id_vac' => $vac])->asArray()->all();
		foreach ($_jcv as $item) {
			$jcv[] = $item['id_cat'];
		}
		if (is_array($jcv)) {
			$jc = JobCategory::find()->where('id IN (' . implode(',', $jcv) . ') ')->asArray()->all();
			return $jc;
		} else return false;
	}

	// Вспомогательные функции
	public static function years()
	{
		for ($i = 2025; $i >= 1950; $i--) {
			$arr[$i] = $i . ' год.';
		}
		return $arr;
	}

	public static function ageToStr($Age)
	{
		$str = '';
		$num = $Age > 100 ? substr($Age, -2) : $Age;
		if ($num >= 5 && $num <= 14) $str = "лет";
		else {
			$num = substr($Age, -1);
			if ($num == 0 || ($num >= 5 && $num <= 9)) $str = 'лет';
			if ($num == 1) $str = 'год';
			if ($num >= 2 && $num <= 4) $str = 'года';
		}
		return $Age . ' ' . $str;
	}

	public static function months()
	{
		return [
			'01' => 'январь',
			'02' => 'февраль',
			'03' => 'март',
			'04' => 'апрель',
			'05' => 'май',
			'06' => 'июнь',
			'07' => 'июль',
			'08' => 'август',
			'09' => 'сентябрь',
			'10' => 'октябрь',
			'11' => 'ноябрь',
			'12' => 'декабрь',
		];
	}

	public static function months_r()
	{
		return [
			'01' => 'января',
			'02' => 'февраля',
			'03' => 'марта',
			'04' => 'апреля',
			'05' => 'мая',
			'06' => 'июня',
			'07' => 'июля',
			'08' => 'августа',
			'09' => 'сентября',
			'10' => 'октября',
			'11' => 'ноября',
			'12' => 'декабря',
		];
	}

	public static function getMonth($i, $r = false)
	{
		if ($r) {
			$months = self::months_r();
		} else {
			$months = self::months();
		}
		return $months[$i];
	}

	public static function sex()
	{
		return [
			's' => 'Не важно',
			'm' => 'Мужской',
			'f' => 'Женский'
		];
	}

	public static function getSex($sex)
	{
		$s = self::sex();
		return $s[$sex];
	}

	public static function employment()
	{
		return [
			'0' => 'Не важно',
			'1' => 'Вахтовый метод',
			'2' => 'Неполный день',
			'3' => 'Полный день',
			'4' => 'Свободный график',
			'5' => 'Сменный график',
			'6' => 'Удаленная работа',
			'7' => 'Проектная работа',
			'8' => 'Стажировка',
			'9' => 'Волонтерство',
		];
	}

	public static function getEmployment($empl)
	{
		$e = self::employment();
		return $e[$empl];
	}

	public static function getEdu($edu)
	{
		$education = self::edu();
		return $education[$edu];
	}

	public static function edu()
	{
		return [
			'1' => 'Среднее',
			'2' => 'Среднее специальное',
			'3' => 'Неоконченное высшее',
			'4' => 'Высшее',
			'5' => 'Бакалавр',
			'6' => 'Магистр',
			'7' => 'Кандидат наук',
			'8' => 'Доктор наук'
		];
	}

	public static function getEduf($edu)
	{
		$education = self::eduf();
		return $education[$edu];
	}

	public static function eduf()
	{
		return [
			'0' => 'Не важно',
			'1' => 'Среднее',
			'2' => 'Среднее специальное',
			'3' => 'Неоконченное высшее',
			'4' => 'Высшее',
			'5' => 'Бакалавр',
			'6' => 'Магистр',
			'7' => 'Кандидат наук',
			'8' => 'Доктор наук'
		];
	}


}