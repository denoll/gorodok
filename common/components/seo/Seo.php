<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 07.08.2016
 * Time: 15:18
 */

namespace common\components\seo;

use Yii;
use common\models\Metatags;
use yii\base\Component;

/**
 * Class Seo
 * @package common\components\seo
 * @property string $key
 * @property string $data
 */
class Seo extends Component
{
	public $key;
	private $data;

	/**
	 * @return null|static
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * @param $key
	 * @return mixed|null|static
	 */
	public function getByKey($key)
	{
		if(!empty($key)){
			$this->data = Yii::$app->cache->get($key);
			if(!$this->data){
				$this->data = Metatags::findOne($key);
				Yii::$app->cache->set($key, $this->data, 604800); //на неделю
			}
		}
		$this->key = $key;
		if(!empty($this->data)){
			return $this->data;
		}return null;
	}

}
