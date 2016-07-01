<?php
/**
 * Created by DENOLL LLC http://denoll.ru.
 * User:  Denis Oleynikov
 * Email: denoll@denoll.ru
 * Date: 28.06.2016
 * Time: 18:11
 */

namespace common\widgets\yamaps;



use yii\bootstrap\Html;
use yii\bootstrap\Widget;
use yii\web\View;

class YaMap extends Widget
{
	public $lat = 55.154656;
	public $lon = 124.729236;
	public $firm_name;
	public $address;
	public $width = '100%';
	public $height = '400px';
	public $zoom = 13;

	public function init()
	{
		parent::init();
		echo Html::tag('div',null,['id'=>'map', 'style'=>'width: '.$this->width.'; height: '.$this->height.';']);
	}

	/**
	 * @return mixed
	 */
	public function run()
	{
		$js = <<<JS
		ymaps.ready(init)
		function init(){     
			map = new ymaps.Map("map", {
				center: [latit, longit],
				zoom: zoom
			});
			myGeoObject = new ymaps.GeoObject({
            // Описание геометрии.
            geometry: {
                type: "Point",
                coordinates: [latit, longit]
            },
            // Свойства.
            properties: {
                // Контент метки.
                iconContent: firm_name,
                hintContent: address
            }
        }, {
            // Опции.
            // Иконка метки будет растягиваться под размер ее содержимого.
            preset: 'islands#blackStretchyIcon',
            // Метку можно перемещать.
            draggable: false
        });
		map.geoObjects.add(myGeoObject);
		}
JS;
		$this->firm_name = $this->replace_quotes($this->firm_name);
		$this->address = $this->replace_quotes($this->address);

		$this->view->registerJsFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
		$this->view->registerJs('
		var latit = '.$this->lat. ';
		var longit = '.$this->lon .'; 
		var zoom = '.$this->zoom. ';
		var firm_name = "'.$this->firm_name.'";
		var address = "'.$this->address.'";
		'
			, View::POS_END);
		$this->view->registerJs($js, View::POS_END);
	}

	public function replace_quotes($str)
	{
		$str = preg_replace('/(?:"([^>]*)")(?!>)/', '«$1»', $str);
		return $str;
	}

}