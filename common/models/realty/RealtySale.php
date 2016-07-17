<?php

namespace common\models\realty;

use common\widgets\Arrays;
use Yii;
use common\models\users\User;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

/**
 * This is the model class for table "realty_sale".
 *
 * @property string $id
 * @property string $id_cat
 * @property string $id_user
 * @property integer $status
 * @property integer $buy
 * @property string $name
 * @property string $cost
 * @property string $area_home
 * @property string $area_land
 * @property integer $floor
 * @property integer $floor_home
 * @property integer $resell
 * @property integer $in_city
 * @property string $distance
 * @property string $main_img
 * @property string $address
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $vip_date
 * @property string $adv_date
 * @property string $m_keyword
 * @property string $m_description
 */
class RealtySale extends \yii\db\ActiveRecord
{
	public $images = array();
	public $reCaptcha;
	public $readonly;

	public function behaviors()
	{
		return [
			[
				'class' => 'denoll\filekit\behaviors\UploadBehavior',
				'filesStorage' => 'realtySaleStorage',
				'multiple' => true,
				'attribute' => 'images',
				'uploadRelation' => 'saleImages',
				'pathAttribute' => 'img',
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
					// ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
		return 'realty_sale';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_cat', 'name', 'address'], 'required'],
			['id_cat', 'validateReadonly'],
			[['id_cat', 'id_user', 'status', 'buy', 'floor', 'floor_home', 'resell', 'in_city', 'type', 'elec', 'gas', 'water', 'heating', 'tel_line', 'internet', 'repair', 'count_img'], 'integer'],
			[['cost', 'area_home', 'area_land', 'distance'], 'number'],
			[['distance'], 'default', 'value' => 0],
			[['description'], 'string', 'max' => 1000],
			[['created_at', 'updated_at', 'vip_date', 'adv_date', 'images'], 'safe'],
			[['name'], 'string', 'max' => 50],
			[['main_img', 'address', 'm_keyword', 'm_description'], 'string', 'max' => 255],
			[['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => RealtyCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
			[['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
			[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'on' => 'create'],
			[['description', 'name', 'address'], \common\components\stopWords\StopWord::className()],
		];
	}

	public function validateReadonly()
	{
		$cat = RealtyCat::findOne(['id' => $this->id_cat]);
		if ($cat->readonly) {
			$readonly = true;
		} else {
			$readonly = false;
		}
		if ($readonly) {
			Yii::$app->session->setFlash('danger', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
			$this->addError('id_cat', 'Выберите категорию! (Выбирать можно только конечные категории помеченные синими иконками).');
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'Номер объявления',
			'id_cat' => 'Категория',
			'id_user' => 'Пользователь',
			'status' => 'Статус',
			'buy' => 'Куплю',
			'name' => 'Укажите заголовок обявления',
			'cost' => 'Укажите стоимость',
			'area_home' => 'Площадь',
			'area_land' => 'Площадь участка',
			'floor' => 'Этаж',
			'floor_home' => 'Этажей в доме',
			'resell' => 'Отметьте если это новострока',
			'in_city' => 'Отметьте если объект находится в городе',
			'distance' => 'Расстояние до города (в км.)',
			'repair' => 'Ремонт',
			'type' => 'Тип строения',
			'gas' => 'Газ',
			'water' => 'Вода',
			'heating' => 'Отопление',
			'tel_line' => 'Телефон',
			'internet' => 'Интернет',
			'main_img' => 'Изображение',
			'address' => 'Адрес',
			'description' => 'Описание',
			'created_at' => 'Дата объявления',
			'updated_at' => 'Дата поднятия',
			'vip_date' => 'Выделено',
			'adv_date' => 'Реклама',
			'm_keyword' => 'Ключевые слова',
			'm_description' => 'Мета описание',
			'reCaptcha' => 'Докажите что Вы не робот.',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCat()
	{
		return $this->hasOne(RealtyCat::className(), ['id' => 'id_cat']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSaleImages()
	{
		return $this->hasMany(RealtySaleImg::className(), ['id_ads' => 'id']);
	}
}
