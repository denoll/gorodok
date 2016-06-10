<?php

namespace common\models\banners;

use Yii;
use \yii\db\ActiveRecord;
use yii\web\UploadedFile;
use common\behaviors\CacheInvalidateBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use common\models\users\User;

/**
 * This is the model class for table "banner_item".
 *
 * @property integer $id
 * @property integer $id_adv_company
 * @property integer $id_user
 * @property string $banner_key
 * @property integer $size
 * @property string $path
 * @property string $url
 * @property string $caption
 * @property integer $status
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $click_count
 * @property integer $max_click
 * @property string $start
 * @property string $stop
 * @property UploadedFile $bannerImage
 *
 * @property BannerAdv $idAdvCompany
 * @property User $user
 * @property Banner $banner
 */
class BannerItem extends ActiveRecord
{

	public $bannerImage;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'banner_item';
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		//$key = array_search('banner_key', $scenarios[self::SCENARIO_DEFAULT], true);
		//$scenarios[self::SCENARIO_DEFAULT][$key] = '!banner_key';
		return $scenarios;
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			'cacheInvalidate' => [
				'class' => CacheInvalidateBehavior::className(),
				'cacheComponent' => 'frontendCache',
				'keys' => [
					function ($model) {
						return [
							Banner::className(),
							$model->banner->key
						];
					}
				]
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_adv_company', 'id_user', 'status', 'order', 'created_at', 'updated_at', 'click_count', 'max_click', 'size'], 'integer'],
			[['start', 'stop'], 'safe'],
			[['banner_key'], 'string', 'max' => 32],
			[['path', 'url', 'caption'], 'string', 'max' => 255],
			[['id_adv_company'], 'exist', 'skipOnError' => true, 'targetClass' => BannerAdv::className(), 'targetAttribute' => ['id_adv_company' => 'id']],
			[['banner_key'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['banner_key' => 'key']],
			[['bannerImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'id_adv_company' => 'Рекламная компания',
			'id_user' => 'Рекламодатель',
			'banner_key' => 'Расположение баннера',
			'path' => 'Картинка баннера',
			'size' => 'Размер баннера',
			'url' => 'Ссылка баннера',
			'caption' => 'Заголовок баннера',
			'status' => 'Статус баннера',
			'order' => 'Порядок расположения баннера',
			'created_at' => 'Дата создания',
			'updated_at' => 'Дата изменения',
			'click_count' => 'Кол-во кликов',
			'max_click' => 'Максимальное кол-во кликов',
			'start' => 'Дата начала показа',
			'stop' => 'Дата окончания показа',
			'bannerImage' => 'Картинка баннера',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAdvert()
	{
		return $this->hasOne(BannerAdv::className(), ['id' => 'id_adv_company'])->inverseOf('bannerItems');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'id_user'])->inverseOf('bannerItems');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBanner()
	{
		return $this->hasOne(Banner::className(), ['key' => 'banner_key']);
	}

	/**
	 * @return string
	 */
	public function getImageUrl()
	{
		return trim($this->path);
	}

	public static function bannerImgDir($name = null)
	{
		if($name){
			$path = Url::to('@frt_dir/img/banners/'.$name);
		}else{
			$path = Url::to('@frt_dir/img/banners/');
		}
		return $path;
	}
	public static function bannerImgUrl($name = null)
	{
		if($name){
			$path = Url::to('@frt_url/img/banners/'.$name);
		}else{
			$path = Url::to('@frt_url/img/banners/');
		}
		return $path;
	}

	public function upload()
	{
		if ($this->validate() && $this->bannerImage) {
			$img_name = md5($this->bannerImage->baseName) . '.' . $this->bannerImage->extension;
			$this->bannerImage->saveAs(self::bannerImgDir($img_name));
			$this->bannerImage = null;
			return $img_name;
		} else {
			return null;
		}
	}

	/**
	 * @return array
	 */
	public static function bannerSize()
	{
		return [
			'1' => 'Размер 1',
			'2' => 'Размер 2',
			'3' => 'Размер 3',
			'4' => 'Размер 4',
			'5' => 'Размер 5',
			'6' => 'Размер 6',
			'7' => 'Размер 7',
			'8' => 'Размер 8',
			'9' => 'Размер 9',
			'10' => 'Размер 10',
			'11' => 'Размер 11',
			'12' => 'Размер 12',
		];
	}
}
