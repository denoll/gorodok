<?php

namespace common\models\auto;

use common\models\users\User;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;


/**
 * This is the model class for table "auto_item".
 *
 * @property integer $id
 * @property integer $id_model
 * @property integer $id_brand
 * @property integer $id_modify
 * @property integer $id_user
 * @property integer $status
 * @property integer $order
 * @property string $vin
 * @property string $price
 * @property integer $new
 * @property integer $body
 * @property integer $transmission
 * @property integer $year
 * @property integer $distance
 * @property integer $power
 * @property string $volume
 * @property integer $color
 * @property integer $customs
 * @property integer $stage
 * @property integer $crash
 * @property integer $door
 * @property integer $motor
 * @property integer $privod
 * @property integer $climate_control
 * @property integer $wheel
 * @property integer $wheel_power
 * @property integer $wheel_drive
 * @property integer $wheel_leather
 * @property integer $termal_glass
 * @property integer $auto_cabin
 * @property integer $sunroof
 * @property integer $heat_front_seat
 * @property integer $heat_rear_seat
 * @property integer $heat_mirror
 * @property integer $heat_rear_glass
 * @property integer $heat_wheel
 * @property integer $power_front_seat
 * @property integer $power_rear_seat
 * @property integer $power_mirror
 * @property integer $power_wheel
 * @property integer $folding_mirror
 * @property integer $memory_front_seat
 * @property integer $memory_rear_seat
 * @property integer $memory_mirror
 * @property integer $memory_wheel
 * @property integer $auto_jockey
 * @property integer $sensor_rain
 * @property integer $sensor_light
 * @property integer $partkronic_rear
 * @property integer $parktronic_front
 * @property integer $blind_spot_control
 * @property integer $camera_rear
 * @property integer $cruise_control
 * @property integer $computer
 * @property integer $signaling
 * @property integer $central_locking
 * @property integer $immobiliser
 * @property integer $satelite
 * @property integer $airbags_front
 * @property integer $airbags_knee
 * @property integer $airbags_curtain
 * @property integer $airbags_side_front
 * @property integer $airbags_side_rear
 * @property integer $abs
 * @property integer $traction
 * @property integer $rate_stability
 * @property integer $brakeforce
 * @property integer $emergency_braking
 * @property integer $block_diff
 * @property integer $pedestrian_detect
 * @property integer $cd_system
 * @property integer $mp3
 * @property integer $radio
 * @property integer $tv
 * @property integer $video
 * @property integer $wheel_manage
 * @property integer $usb
 * @property integer $aux
 * @property integer $bluetooth
 * @property integer $gps
 * @property integer $audio_system
 * @property integer $subwoofer
 * @property integer $headlight
 * @property integer $headlight_fog
 * @property integer $headlight_washers
 * @property integer $adaptive_light
 * @property integer $bus
 * @property integer $bus_winter_in
 * @property integer $owners
 * @property integer $service_book
 * @property integer $dealer_serviced
 * @property integer $garanty
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $top_date
 * @property string $vip_date
 * @property string $mk
 * @property string $md
 *
 * @property Image $images
 *
 * @property User $user
 * @property User $userActive
 * @property AutoImg[] $autoImg
 * @property AutoBrands $brand
 * @property AutoModels $model
 * @property AutoModify $modify
 */
class AutoItem extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DISABLE = 0;
	const STATUS_VERIFICATION = 2;

	public $images = array();
	public $reCaptcha;


	public function behaviors()
	{
		return [
			[
				'class' => 'denoll\filekit\behaviors\UploadBehavior',
				'filesStorage' => 'realtySaleStorage',
				'multiple' => true,
				'attribute' => 'images',
				'uploadRelation' => 'autoImg',
				'pathAttribute' => 'path',
				'baseUrlAttribute' => 'base_url',
				'typeAttribute' => 'type',
				'sizeAttribute' => 'size',
				'nameAttribute' => 'name',
				'orderAttribute' => 'order'
			],
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					//ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'auto_item';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_model', 'id_brand', 'id_modify', 'id_user', 'status', 'order', 'new', 'body', 'transmission', 'year',
				'distance', 'power', 'customs', 'stage', 'crash', 'door', 'motor', 'privod', 'climate_control',
				'wheel', 'wheel_power', 'wheel_drive', 'wheel_leather',
				'termal_glass', 'auto_cabin', 'sunroof', 'heat_front_seat', 'heat_rear_seat',
				'heat_mirror', 'heat_rear_glass', 'heat_wheel', 'power_front_seat', 'power_rear_seat', 'power_mirror', 'power_wheel', 'folding_mirror',
				'memory_front_seat', 'memory_rear_seat', 'memory_mirror', 'memory_wheel',
				'auto_jockey', 'sensor_rain', 'sensor_light', 'partkronic_rear', 'parktronic_front', 'blind_spot_control', 'camera_rear', 'cruise_control', 'computer',
				'signaling', 'central_locking', 'immobiliser', 'satelite', 'airbags_front', 'airbags_knee', 'airbags_curtain', 'airbags_side_front', 'airbags_side_rear',
				'abs', 'traction', 'rate_stability', 'brakeforce', 'emergency_braking', 'block_diff', 'pedestrian_detect',
				'cd_system', 'mp3', 'radio', 'tv', 'video', 'wheel_manage', 'usb', 'aux', 'bluetooth', 'gps', 'audio_system', 'subwoofer',
				'headlight', 'headlight_fog', 'headlight_washers', 'adaptive_light', 'bus', 'bus_winter_in',
				'owners', 'service_book', 'dealer_serviced', 'garanty'], 'integer'],

			[['id_model', 'id_brand', 'price', 'new', 'body', 'transmission', 'year', 'distance', 'volume', 'power', 'motor', 'privod', 'stage', 'door', 'wheel', 'color'], 'required'],
			[['price', 'volume'], 'number'],
			[['created_at', 'updated_at', 'top_date', 'vip_date', 'images'], 'safe'],
			[['color'], 'string', 'max' => 7],
			[['vin'], 'string', 'max' => 20],
			[['description'], 'string', 'max' => 2032],
			[['mk', 'md'], 'string', 'max' => 255],
			[['id_brand'], 'exist', 'skipOnError' => true, 'targetClass' => AutoBrands::className(), 'targetAttribute' => ['id_brand' => 'id']],
			[['id_model'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModels::className(), 'targetAttribute' => ['id_model' => 'id']],
			[['id_modify'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModify::className(), 'targetAttribute' => ['id_modify' => 'id']],
			[['description'], \common\components\stopWords\StopWord::className()],
			[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'on' => 'create'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_model' => 'Модель',
			'id_brand' => 'Марка',
			'id_modify' => 'Модификация',
			'id_user' => 'Подал объявление',
			'status' => 'Статус',
			'order' => 'Порядок',
			'vin' => 'VIN номер автомобиля',
			'price' => 'Стоимость(руб)',
			'new' => 'Новый / С пробегом',
			'body' => 'Кузов',
			'transmission' => 'Коробка',
			'year' => 'Год выпуска',
			'power' => 'Мощность двигателя',
			'volume' => 'Объем двигателя',
			'distance' => 'Пробег(км)',
			'color' => 'Цвет',
			'customs' => 'Растаможен',
			'stage' => 'Стостояние',
			'crash' => 'Битая',
			'door' => 'Кол-во дверей',
			'motor' => 'Тип двигателя',
			'privod' => 'Привод',
			'climate_control' => 'Климат контроль',
			'wheel' => 'Руль',
			'wheel_power' => 'Усилитель руля',
			'wheel_drive' => 'Управление климатконтролем на руле',
			'wheel_leather' => 'Кожанный руль',
			'termal_glass' => 'Атермальное остекление',
			'auto_cabin' => 'Салон авто',
			'sunroof' => 'Люк',
			'heat_front_seat' => 'Обогрев передних сидений',
			'heat_rear_seat' => 'Обогрев задних сидений',
			'heat_mirror' => 'Обогрев зеркал',
			'heat_rear_glass' => 'Обогрев заднего стекла',
			'heat_wheel' => 'Обогрев руля',
			'power_front_seat' => 'Электропривод передних сидений',
			'power_rear_seat' => 'Электропривод задних сидений',
			'power_mirror' => 'Электропривод зеркал',
			'power_wheel' => 'Электропривод рулевой колонки',
			'folding_mirror' => 'Складывание зеркал',
			'memory_front_seat' => 'Передних сидений',
			'memory_rear_seat' => 'Задних сидений',
			'memory_mirror' => 'Зеркал',
			'memory_wheel' => 'Руля',
			'auto_jockey' => 'Автоматический парковщик',
			'sensor_rain' => 'Датчик дождя',
			'sensor_light' => 'Датчик света',
			'partkronic_rear' => 'Парктроник задний',
			'parktronic_front' => 'Парктроник передний',
			'blind_spot_control' => 'Система контроля слепых зон',
			'camera_rear' => 'Камера заднего вида',
			'cruise_control' => 'Круиз-контроль',
			'computer' => 'Бортовой компьютер',
			'signaling' => 'Сигнализация',
			'central_locking' => 'Центральный замок',
			'immobiliser' => 'Иммобилайзер',
			'satelite' => 'Спутник',
			'airbags_front' => 'Фронтальные',
			'airbags_knee' => 'Коленные',
			'airbags_curtain' => 'Шторки',
			'airbags_side_front' => 'Боковые передние',
			'airbags_side_rear' => 'Боковые задние',
			'abs' => 'Антиблокировка тормозов (ABS)',
			'traction' => 'Антипробуксовка',
			'rate_stability' => 'Курсовая устойчивость',
			'brakeforce' => 'Распред. тормозных усилий',
			'emergency_braking' => 'Экстренное торможение',
			'block_diff' => 'Блок. дифференциала',
			'pedestrian_detect' => 'Обнаружение пешеходов',
			'cd_system' => 'CD/DVD/Blu-ray',
			'mp3' => 'MP3',
			'radio' => 'Радио',
			'tv' => 'TV',
			'video' => 'Видео',
			'wheel_manage' => 'Управление аудио на руле',
			'usb' => 'USB',
			'aux' => 'AUX',
			'bluetooth' => 'Bluetooth',
			'gps' => 'GPS-навигатор',
			'audio_system' => 'Аудиосистема',
			'subwoofer' => 'Сабвуфер',
			'headlight' => 'Фары',
			'headlight_fog' => 'Противотуманные',
			'headlight_washers' => 'Омыватели фар',
			'adaptive_light' => 'Адаптивное освещение',
			'bus' => 'Шины и диски',
			'bus_winter_in' => 'Зимние шины в комплекте',
			'owners' => 'Владельцев по ПТС',
			'service_book' => 'Есть сервисная книжка',
			'dealer_serviced' => 'Обслуживался у дилера',
			'garanty' => 'На гарантии',
			'description' => 'Описание',
			'created_at' => 'Создано',
			'updated_at' => 'Изменено',
			'top_date' => 'Поднято',
			'vip_date' => 'Выделено',
			'mk' => 'Ключевые слова',
			'md' => 'Мета описание',
			'reCaptcha' => 'Докажите что Вы не робот',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAutoImg()
	{
		return $this->hasMany(AutoImg::className(), ['id_item' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUserActive()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user'])->andWhere(['status'=>User::STATUS_ACTIVE]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBrand()
	{
		return $this->hasOne(AutoBrands::className(), ['id' => 'id_brand']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModel()
	{
		return $this->hasOne(AutoModels::className(), ['id' => 'id_model']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModify()
	{
		return $this->hasOne(AutoModify::className(), ['id' => 'id_modify']);
	}
}
