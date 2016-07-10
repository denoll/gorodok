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

class CurseWidget extends Widget
{
	public function init()
	{
		$data = self::getJsonFile();
		if (!$data) return null;
		$str = '<div class="valute"><i class="fa fa-calendar"></i>&nbsp;' . date('d.m.Y') . '&nbsp;&nbsp;&nbsp;';

		$str .= '<span><i class="fa fa-usd"></i>&nbsp;' . $data['courseUsd'] . '</span>&nbsp;&nbsp;&nbsp;';

		$str .= '<span><i class="fa fa-eur"></i>&nbsp;' . $data['courseEur'] . '</span>';

		$str .= '</div>';

		return $str;
	}

	public static function getJsonFile()
	{
		$url = Yii::getAlias('@frt_url/temp');
		$dir = Yii::getAlias('@frt_dir/temp');
		$file = $dir . '/course.json';
		if (file_exists($file)) {
			$data = file_get_contents($url . '/course.json');
			$json = json_decode($data, true);
			if (($json['create'] + (60 * 60 * 12)) < time()) {
				if (!self::setJsonFile($file)) return false;
				$data = file_get_contents($url . '/course.json');
			} else {
				$data = file_get_contents($url . '/course.json');
			}
		} else {
			if (!self::setJsonFile()) return false;
			$data = file_get_contents($url . '/course.json');
		}
		return json_decode($data, true);
	}

	public static function setJsonFile($file)
	{
		$url = Yii::getAlias('@frt_dir/temp');
		$request = 'http://www.cbr.ru/scripts/XML_daily.asp';

		//if (self::checkUrl($request)) {
			$status = get_headers($request);
			if (in_array("HTTP/1.1 200 OK", $status) or in_array("HTTP/1.0 200 OK", $status)) {
				$xml = simplexml_load_file($request);
			}
			if ($xml && isset($xml)) {
				unlink($file);
				$date = $xml['Date'];
				foreach ($xml as $val) {
					if ($val['ID'] == 'R01235') {
						$courseUsd = substr($val->Value, 0, -2);
					}
					if ($val['ID'] == 'R01239') {
						$courseEur = substr($val->Value, 0, -2);
					}
				}
				$str = $date . ';' . $courseUsd . ';' . $courseEur;
				$arr = explode(';', $str);
				$json = [
					'date' => $arr[0],
					'courseUsd' => $arr[1],
					'courseEur' => $arr[2],
					'create' => time(),
				];
				file_put_contents($url . '/course.json', json_encode($json));
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