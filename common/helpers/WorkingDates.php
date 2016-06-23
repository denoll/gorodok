<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 20.06.2016
 * Time: 16:20
 */

namespace common\helpers;


class WorkingDates
{
	/**
	 * Кол-во дней от текущей даты
	 * @param $date_time
	 * @return float
	 */
	public static function getDayCountUpNow($date_time)
	{
		return floor((strtotime(date('Y-m-d H:i:s'))-strtotime($date_time))/86400);
	}

}