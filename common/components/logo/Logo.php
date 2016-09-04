<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User: Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 07.08.2016
 * Time: 15:18
 */

namespace common\components\logo;

use Yii;
use yii\base\Component;
use yii\bootstrap\Html;

/**
 * Class Seo
 * @package common\components\seo
 * @property string $img
 * @property string $text
 * @property string $type
 * @property array $options
 */
class Logo extends Component
{
	public $img;
	public $text;
	public $type = 'img';
	public $options;

	/**
	 * @return string
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * @return string
	 */
	public function getLogo()
	{
		if($this->type === 'img' && !empty($this->img)){
			$result  = Html::img($this->img, $this->options);
		}elseif ($this->type === 'text' && !empty($this->text)){
			$result = $this->text;
		}else{
			$result = Yii::$app->name;
		}
		return $result;
	}
	/**
	 * @return string
	 */
	public function getLogoLink()
	{
		if($this->type === 'img' && !empty($this->img)){
			$result  = $this->img;
		}elseif ($this->type === 'text' && !empty($this->text)){
			$result = $this->text;
		}else{
			$result = Yii::$app->name;
		}
		return $result;
	}
}
