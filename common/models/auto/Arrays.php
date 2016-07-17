<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 15.07.2016
 * Time: 20:45
 */

namespace common\models\auto;


use common\models\users\User;
use yii\helpers\ArrayHelper;

class Arrays
{
	/**
	 * @return array
	 */
	public static function statusAuto()
	{
		return [
			AutoItem::STATUS_ACTIVE => 'Опубликовано',
			AutoItem::STATUS_DISABLE => 'Не опубликовано',
			AutoItem::STATUS_VERIFICATION => 'На проверке',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getStatusAuto($id)
	{
		$arr  =self::statusAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function newAuto()
	{
		return [
			'1' => 'С пробегом',
			'2' => 'Новая',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getNewAuto($id)
	{
		$arr = self::newAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function bodyAuto()
	{
		return [
			'1'  => 'седан',
			'2'  => 'хетчбэк',
			'3'  => 'универсал',
			'4'  => 'внедорожник',
			'5'  => 'кроссовер',
			'6'  => 'купе',
			'7'  => 'кабриолет',
			'8'  => 'минивэн',
			'9'  => 'пикап',
			'10'  => 'фургон',
			'11' => 'микроавтобус',
			'12' => 'лимузин',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getBodyAuto($id)
	{
		$arr = self::bodyAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function transmissionAuto()
	{
		return [
			'1'  => 'Механика',
			'2'  => 'Автомат',
			'3'  => 'Робот',
			'4'  => 'Вариатор',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getTransmissionAuto($id)
	{
		$arr = self::transmissionAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function stageAuto()
	{
		return [
			'1'  => 'Не требует ремонта',
			'2'  => 'Требует мелкого ремонта',
			'3'  => 'Требует крупного ремонта',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getStageAuto($id)
	{
		$arr = self::stageAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function doorsAuto()
	{
		return [
			'1'  => 'Две',
			'2'  => 'Три',
			'3'  => 'Четыре',
			'4'  => 'Пять',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getDoorsAuto($id)
	{
		$arr = self::doorsAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function motorAuto()
	{
		return [
			'1'  => 'Бензин',
			'2'  => 'Дизель',
			'3'  => 'Гибрид',
			'4'  => 'Робот',
			'5'  => 'Вариатор',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getMotorAuto($id)
	{
		$arr = self::motorAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function privodAuto()
	{
		return [
			'1'  => 'Передний',
			'2'  => 'Задний',
			'3'  => 'Полный',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getPrivodAuto($id)
	{
		$arr = self::privodAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function wheelAuto()
	{
		return [
			'1'  => 'Левый',
			'2'  => 'Правый',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getWheelAuto($id)
	{
		$arr = self::wheelAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function wheelPower()
	{
		return [
			'1'  => 'Гидроусилитель',
			'2'  => 'Электроусилитель',
			'3'  => 'Гидроэлектроусилитель',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getWheelPower($id)
	{
		$arr = self::wheelPower();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function climateControl()
	{
		return [
			'1'  => 'Кондиционер',
			'2'  => 'Однозонный',
			'3'  => 'Мультизонный',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getClimateControl($id)
	{
		$arr = self::climateControl();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function cabinAuto()
	{
		return [
			'1'  => 'Ткань',
			'2'  => 'Велюр',
			'3'  => 'Кожа',
			'4'  => 'Кожа алькантара',
			'5'  => 'Эко-кожа',
			'6'  => 'Комбинированный',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getCabinAuto($id)
	{
		$arr = self::cabinAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function audioSystem()
	{
		return [
			'1'  => '2 колонки',
			'2'  => '4 колонки',
			'3'  => '6 колонок',
			'4'  => '8+ колонок',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getAudioSystem($id)
	{
		$arr = self::cabinAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function headlightAuto()
	{
		return [
			'1'  => 'Обычные',
			'2'  => 'Галогенные',
			'3'  => 'Ксеноновые',
			'4'  => 'Светодиодные',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getHeadlightAuto($id)
	{
		$arr = self::headlightAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function ptsAuto()
	{
		return [
			'1'  => '1',
			'2'  => '2',
			'3'  => '3',
			'4'  => '4+',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getPtsAuto($id)
	{
		$arr = self::headlightAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function busAuto()
	{
		for ($i = 7; $i<=30; $i++){
			$arr[$i] = $i . '"';
		}
		return $arr;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getBusAuto($id)
	{
		$arr = self::busAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function colorAuto()
	{
		return [
			'whit'=>'Белый',
			'gray'=>'Серый',
			'silv'=>'Серебристый',
			'blac'=>'Черный',
			'blue'=>'Синий',
			'viol'=>'Фиолетовый',
			'lblu'=>'Голубой',
			'dred'=>'Вишневый',
			'red' =>'Красный',
			'orng'=>'Оранжевый',
			'purp'=>'Пурпурный',
			'yell'=>'Желтый',
			'brwn'=>'Коричневый',
			'gren'=>'Зеленый',
			'gold'=>'Золотистый',
			'brnz'=>'Бронзовый',
		];
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getColorAuto($id){
		$arr = self::colorAuto();
		return $arr[$id];
	}

	/**
	 * @return array
	 */
	public static function yearAuto($year_count = 60)
	{
		$year = date('Y');
		for($i = 0; $i <= $year_count; $i++){
			$y = $year - $i;
			$years[$y] = $y;
		}
		return $years;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public static function getYearAuto($id)
	{
		$arr = self::yearAuto();
		return $arr[$id];
	}

	public static function usersAuto()
	{
		$users =  User::find()->where(['status'=>User::STATUS_ACTIVE])->all();
		return ArrayHelper::map($users, 'id', 'username');
	}

}