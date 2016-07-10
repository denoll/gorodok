<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 18.07.2015
 * Time: 17:01
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;

class WeatherWidget// extends Widget
{
	public static function init()
	{
		$data = self::getJsonFile();

		if ($data) return '<div class="weather">&nbsp;&nbsp;&nbsp;<span title="' . $data['type'] . '"><i class="fa fa-umbrella"></i> &nbsp;' . $data['temp'] . '</span></div>';
	}

	public static function getJsonFile()
	{
		$url = Yii::getAlias('@frt_url/temp');
		$dir = Yii::getAlias('@frt_dir/temp');
		$file = $dir . '/weather.json';
		if (file_exists($file)) {
			$data = file_get_contents($url . '/weather.json');
			$json = json_decode($data, true);
			if (($json['create'] + (60 * 60 * 8)) < time()) {
				if (!self::setJsonFile($file)) return false;
				$data = file_get_contents($url . '/weather.json');
			} else {
				$data = file_get_contents($url . '/weather.json');
			}
		} else {
			if (!self::setJsonFile()) return false;
			$data = file_get_contents($url . '/weather.json');
		}
		return json_decode($data, true);
	}

	public static function setJsonFile($file)
	{
		$url = Yii::getAlias('@frt_dir/temp');
		$request = 'https://api.worldweatheronline.com/free/v2/weather.ashx?q=Tynda&format=XML&num_of_days=1&lang=ru&key=1eb12ad654fc4c3c597cef20bfaa9';
		//if (checkUrl($request)) {
			$status = get_headers($request);
			if (in_array("HTTP/1.1 200 OK", $status) or in_array("HTTP/1.0 200 OK", $status)) {
				$xml = simplexml_load_file($request);
			}
			if ($xml && isset($xml)) {
				unlink($file);
				$data = $xml->current_condition;
				$temp = $data->temp_C;
				$type = $data->lang_ru;
				$icon = $data->weatherIconUrl;
				$str = $temp . ';' . $type . ';' . $icon;
				$arr = explode(';', $str);
				$json = [
					'temp' => $arr[0],
					'type' => $arr[1],
					'icon' => $arr[2],
					'create' => time(),
				];
				file_put_contents($url . '/weather.json', json_encode($json));
			} else return false;
		//} else return false;
	}

	protected static function checkUrl($link)
	{
		$fd = @fsockopen($link, 80);
		if ($fd) {
			fclose($fd);
			return true;
		} else {
			return false;
		}
	}
}