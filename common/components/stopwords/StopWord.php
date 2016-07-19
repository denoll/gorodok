<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 17.07.2016
 * Time: 18:13
 */

namespace common\components\stopWords;

use yii\validators\Validator;

class StopWord extends Validator
{
	public function init()
	{
		parent::init();
		$this->message = 'Вы ввели недопустимое слово.';
	}

	public function validateAttribute($model, $attribute)
	{
		$stop_words = require(__DIR__.'/words.php');
		$text = $model->$attribute;
		foreach ($stop_words as $word){
			$text = mb_strtolower($text, 'utf-8');
			$str_find = "/$word/iU";
			$find = preg_match($str_find, $text);
			if ($find) {
				$model->addError($attribute, 'Вы ввели недопустимое слово.');
			}
		}
	}
}