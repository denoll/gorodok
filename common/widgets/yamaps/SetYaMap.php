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

class SetYaMap extends Widget
{
	public $lat;
	public $lon;
	public $center_lat = 0;
	public $center_lon = 0;
	public $firm_name;
	public $address;
	public $width = '100%';
	public $height = '400px';
	public $zoom = 13;

	public function init()
	{
		parent::init();
		$this->center_lat = \Yii::$app->api->lat();
		$this->center_lon = \Yii::$app->api->lon();
		echo Html::tag('div',null,['id'=>'map', 'style'=>'width: '.$this->width.'; height: '.$this->height.';']);
	}

	/**
	 * @return mixed
	 */
	public function run()
	{
		$js = <<<JS
		ymaps.ready(init)
		function init() {
			
			var myPlacemark,
				myMap = new ymaps.Map('map', {
					center: [center_latit, center_longit],
					zoom: zoom
				}, {
					searchControlProvider: 'yandex#search'
				});
			if(latit || longit){
					myPlacemark = createPlacemark([latit, longit], address);
					myMap.geoObjects.add(myPlacemark);
					// Слушаем событие окончания перетаскивания на метке.
					myPlacemark.events.add('dragend', function () {
						getAddress(myPlacemark.geometry.getCoordinates());
					});
			}
		
			// Слушаем клик на карте.
			myMap.events.add('click', function (e) {
				var coords = e.get('coords');
				
				// Если метка уже создана – просто передвигаем ее.
				if (myPlacemark) {
					myPlacemark.geometry.setCoordinates(coords);
				}
				// Если нет – создаем.
				else {
					myPlacemark = createPlacemark(coords, address);
					myMap.geoObjects.add(myPlacemark);
					// Слушаем событие окончания перетаскивания на метке.
					myPlacemark.events.add('dragend', function () {
						getAddress(myPlacemark.geometry.getCoordinates());
					});
				}
				getAddress(coords);
				
			});
			// Создание метки.
			function createPlacemark(coords, address) {
				if(address){
					return new ymaps.Placemark(coords, {
					iconCaption: firm_name,
					balloonContentBody: [
						'<address>',
						'<strong>Ваш текущий адрес:</strong>',
						'<br/>',
						'Адрес: '+address,
						'<br/>',
						'</address>'
					].join(''),
					balloonContentFooter: '<i>Для изменения текущего адреса перетаците иконку к нужному адресу и щелкните по ней левой кнопкой мыши.</i>',
				}, {
					preset: 'islands#violetDotIconWithCaption',
					draggable: true
				});
				}else{
				return new ymaps.Placemark(coords, {
					iconCaption: 'Найдите свой адрес на карте и щелкните по нему левой кнопкой мышки.'
				}, {
					preset: 'islands#violetDotIconWithCaption',
					draggable: true
				});
				}
			}
			// Определяем адрес по координатам (обратное геокодирование).
			function getAddress(coords) {
				myPlacemark.properties.set('iconCaption', 'поиск...');
				ymaps.geocode(coords).then(function (res) {
					var firstGeoObject = res.geoObjects.get(0);
					myPlacemark.properties
						.set({
							iconCaption: firstGeoObject.properties.get('name'),
							balloonContent: firstGeoObject.properties.get('text')
						});
						console.log(coords);
						$("#firm-lat").val(coords[0]);
						$("#firm-lon").val(coords[1]);
						$("#firm-address").val(firstGeoObject.properties.get('text'));
						console.log(firstGeoObject.properties.get('text'));
				});
				
			}
		}

JS;
		$this->firm_name = $this->replace_quotes($this->firm_name);
		$this->address = $this->replace_quotes($this->address);
		$lat = !empty($this->lat) ? $this->lat : $this->center_lat;
		$lon = !empty($this->lon) ? $this->lon : $this->center_lon;
		$c_lat = !empty($this->lat) ? $this->lat : $this->center_lat;
		$c_lon = !empty($this->lon) ? $this->lon : $this->center_lon;
		$this->view->registerJsFile("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
		$this->view->registerJs('
		var latit = '.$lat.';
		var longit = '.$lon.'; 
		var center_latit = '.$c_lat. ';
		var center_longit = '.$c_lon .'; 
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
