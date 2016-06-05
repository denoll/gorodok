<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 08.02.2016
 * Time: 7:40
 */

namespace app\helpers;


class Texts
{

	const TEXT_CORRECT_IMAGE = 'Выберите новое фото и подгоните выбраный файл под размер рамки, с помощью мышки (увеличить/уменьшить - колесиком мышки), или с помощью тачпада (touchpad).';
	const TEXT_CORRECT_AVATAR = 'Выберите картинку и подгоните выбраный файл под размер рамки, с помощью мышки (увеличить/уменьшить - колесиком мышки), или с помощью тачпада (touchpad).';
	const TEXT_CORRECT_LOGO = 'Выберите логотип и подгоните выбраный файл под размер рамки, с помощью мышки (увеличить/уменьшить - колесиком мышки), или с помощью тачпада (touchpad).';

	public static function messages(){
		return [
			'1' => 'объявления',
			'2' => 'резюме',
			'3' => 'вакансии',
			'4' => 'коллективного письма',
		];
	}

	public static function getMessage($v)
	{
		$message = self::messages();
		return $message[$v];
	}

}