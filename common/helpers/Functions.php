<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 12.07.2016
 * Time: 23:09
 */

namespace common\helpers;


class Functions
{
	public static function subString($string, $length = 100)
	{
		$string = strip_tags($string);
		$strlen = strlen($string);
		if($length < $strlen){
			$string = substr($string, 0, $length);
		}
		$string = rtrim($string, "!.,-");
		//$string = substr($string, 0, mb_strrpos($string, ' '));
		if($length < $strlen){
			$string = $string . ' ... ';
		}
		return $string;
	}
}