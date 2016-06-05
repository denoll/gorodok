<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.10.2015
 * Time: 10:15
 */
namespace app\modules\users\helpers;
use Yii;
class CountryCodes {



	static function getCountry($delimiter=';')
	{
		$filename = Yii::getAlias('@backend/modules/users/helpers/country_iso_codes.csv');
		//if(!file_exists($filename) || !is_readable($filename))
		//	return FALSE;

		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}

	static function  getFlags(){
		$countries = self::getCountry();

		foreach($countries as $i => $country){
			$data[$country['two_char']] =
				$country['name_ru']
			;
			//$data[$i]['id'] = $country[$i]['two_char'];
			//$data[$i]['name'] = $country[$i]['name_ru'];
		}
		return $data;
	}
}