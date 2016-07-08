<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 06.07.2016
 * Time: 2:57
 */

namespace common\helpers;

use yii\bootstrap\Html;
use yii\helpers\Url;

class Thumb
{

	/**
	 * @param $base_url
	 * @param $img
	 * @param null|string $size
	 * @return mixed
	 */
	public static function img($base_url, $img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img($base_url. '/' . $img, [
					'alt' => 'Фото',
					'style' => 'width:120px;'
				]);
			} else {
				return Html::img(Url::to('@frt_url/img/no-img.png'), [
					'alt' => 'Фото',
					'style' => 'width:120px;'
				]);
			}
		} else {
			if ($img != null || $img != '') {
				return Html::img($base_url. '/' . $img, [
					'alt' => 'Фото',
					'style' => 'width:' . $size . ';'
				]);
			} else {
				$avtUrl = Url::to('@frt_url/img/no-img.png');
				return Html::img($avtUrl, [
					'alt' => 'Фото',
					'style' => 'width:' . $size . ';'
				]);
			}
		}
	}

}