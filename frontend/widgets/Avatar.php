<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 14.10.2015
 * Time: 17:51
 */

//Avatar::widget()

namespace frontend\widgets;

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\users\User;


class Avatar
{
	public static function init($size = null)
	{
		$user = \Yii::$app->user->getIdentity();
		if ($size === null) {
			if ($user['avatar'] != null || $user['avatar'] != '') {
				return Html::img(Url::to('@frt_url/img/avatars/' . $user['avatar']), [
					'alt' => 'Аватар',
					'style' => 'width:18px;'
				]);
			} else {
				return Html::img(Url::to('@frt_url/img/avatars/avatar_128.png'), [
					'alt' => 'Аватар',
					'style' => 'width:18px;'
				]);
			}
		} else {
			if ($user['avatar'] != null || $user['avatar'] != '') {
				return Html::img(Url::to('@frt_url/img/avatars/' . $user['avatar']), [
					'alt' => 'Аватар',
					'style' => 'width:' . $size . ';'
				]);
			} else {
				$avtUrl = Url::to('@frt_url/img/avatars/avatar_512.png');
				return Html::img($avtUrl, [
					'alt' => 'Аватар',
					'style' => 'width:' . $size . ';'
				]);
			}
		}
	}

	public static function userAvatar($avatar, $size = null)
	{
		if ($size === null) {
			if ($avatar != null || $avatar != '') {
				return Html::img(Url::to('@frt_url/img/avatars/' . $avatar), [
					'alt' => 'Аватар',
					'style' => 'width:120px;'
				]);
			} else {
				return Html::img(Url::to('@frt_url/img/avatars/avatar_128.png'), [
					'alt' => 'Аватар',
					'style' => 'width:120px;'
				]);
			}
		} else {
			if ($avatar != null || $avatar != '') {
				return Html::img(Url::to('@frt_url/img/avatars/' . $avatar), [
					'alt' => 'Аватар',
					'style' => 'width:' . $size . ';'
				]);
			} else {
				$avtUrl = Url::to('@frt_url/img/avatars/avatar_512.png');
				return Html::img($avtUrl, [
					'alt' => 'Аватар',
					'style' => 'width:' . $size . ';'
				]);
			}
		}
	}

	public static function imgService($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/service/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/service/' . $img), [
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

	public static function imgLetters($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/letters/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/letters/' . $img), [
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

	public static function imgAfisha($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/afisha/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/afisha/' . $img), [
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

	public static function imgNews($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/news/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/news/' . $img), [
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

	public static function imgPage($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/page/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/page/' . $img), [
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

	public static function imgFirm($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/logo/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/logo/' . $img), [
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

	public static function imgGoods($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/goods/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/goods/' . $img), [
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

	public static function imgRealtySale($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/realty_sale/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/realty_sale/' . $img), [
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

	public static function imgRealtyRent($img, $size = null)
	{
		if ($size === null) {
			if ($img != null || $img != '') {
				return Html::img(Url::to('@frt_url/img/realty_rent/' . $img), [
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
				return Html::img(Url::to('@frt_url/img/realty_rent/' . $img), [
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

	public static function Star()
	{
		return Html::img(Url::to('@frt_url/img/star32.png'), [
			'alt' => 'Звезда',
		]);
	}
}