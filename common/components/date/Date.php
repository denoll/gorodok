<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 15.10.2016
 * Time: 10:14
 */

namespace common\components\date;


use yii\base\Component;

class Date extends Component
{
	public function init()
	{
		parent::init(); // TODO: Change the autogenerated stub
	}


	/**
	 * @param $date
	 * @return string
	 */
	public function getDateTime($date)
	{
		$dt = new \DateTime($date);

		return $dt->format('d.m.y H:i');
	}

}
