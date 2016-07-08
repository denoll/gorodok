<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 21.06.2016
 * Time: 14:33
 */

namespace common\helpers;


class Arrays
{
	/**
	 * @return array
	 */
	public static function status()
	{
		return [
			'1' => 'Активный',
			'0' => 'Скрыт',
		];
	}

	public static function getStatus($id)
	{
		$status = self::status();
		return $status[$id];
	}

	/**
	 * @return array
	 */
	public static function statusYesNo()
	{
		return [
			'1' => 'Да',
			'0' => 'Нет',
		];
	}

	public static function getYesNo($id)
	{
		$status = self::statusYesNo();
		return $status[$id];
	}

	/**
	 * @return array
	 */
	public static function statusBanner()
	{
		return [
			'2' => 'На проверке',
			'1' => 'Активный',
			'0' => 'Скрыт',
		];
	}

	/**
	 * @param $id
	 * @return string
	 */
	public static function getStatusBanner($id)
	{
		$status = self::statusBanner();
		return $status[$id];
	}

	/**
	 * @return array
	 */
	public static function typeKonkurs()
	{
		return [
			'1' => 'По очкам',
			'0' => 'За или Против',
		];
	}

	/**
	 * @param $id
	 * @return string
	 */
	public static function getTypeKonkurs($id)
	{
		$status = self::typeKonkurs();
		return $status[$id];
	}
}