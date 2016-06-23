<?php

namespace common\models\banners;

use common\behaviors\FileStorageBehavior;
use common\helpers\WorkingDates;
use common\models\users\Query;
use common\models\users\UserAccount;
use Yii;
use \yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\UploadedFile;
use denoll\filekit\behaviors\UploadBehavior;
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
 * @property string $base_url
 * @property string $url
 * @property string $caption
 * @property integer $status
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $click_count
 * @property integer $hit_count
 * @property integer $max_click
 * @property integer $max_hit
 * @property integer $last_hit
 * @property integer $last_click
 * @property integer $last_day
 * @property integer $max_day
 * @property integer $day_count
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

	const STATUS_DISABLE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_VERIFICATION = 2;

	public $files = array();

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
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at','start'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
				'value' => new Expression('NOW()'),
			],
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
			],
			'file' => [
				'class' => UploadBehavior::className(),
				'filesStorage' => 'bannerStorage',
				'attribute' => 'files',
				'pathAttribute' => 'path',
				'baseUrlAttribute' => 'base_url',
			],
			/*'fileStorage' => [
				'class' => FileStorageBehavior::className(),
				'model' => $this,
				'directory' => 'banners',
				'file' => 'bannerImage',
				'file_name' => 'path'
			],*/
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_adv_company', 'id_user', 'status', 'order', 'created_at', 'updated_at', 'size',
				'click_count', 'last_click', 'max_click',
				'hit_count', 'last_hit', 'max_hit',
				'day_count','last_day', 'max_day',
			], 'integer'],
			[['start', 'stop'], 'safe'],
			[['banner_key'], 'string', 'max' => 32],
			[['base_url', 'path', 'url', 'caption'], 'string', 'max' => 255],
			[['id_adv_company'], 'exist', 'skipOnError' => true, 'targetClass' => BannerAdv::className(), 'targetAttribute' => ['id_adv_company' => 'id']],
			[['banner_key'], 'exist', 'skipOnError' => true, 'targetClass' => Banner::className(), 'targetAttribute' => ['banner_key' => 'key']],
			//[['bannerImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
			[['files'], 'safe'],
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
			'hit_count' => 'Кол-во показов',
			'day_count' => 'Кол-во дней',
			'max_click' => 'Максимальное кол-во кликов',
			'max_hit' => 'Максимальное кол-во показов',
			'max_day' => 'Максимальное кол-во дней',
			'last_hit' => 'Последний оплаченый показ',
			'last_click' => 'Последний оплаченый клик',
			'last_day' => 'Последний оплаченый день',
			'start' => 'Дата начала показа',
			'stop' => 'Дата окончания показа',
			'files' => 'Картинка баннера',
		];
	}

	/**
	 * Выборка элементов баннеров по ключу
	 * @param \common\models\banners\Banner $key Ключ
	 * @return $this
	 */
	public static function findItemsByKey($key)
	{
		$statuses = self::find()->joinWith('advert')->where(['{{%banner_item}}.status' => 1, '{{%banner_item}}.banner_key'=>$key])->asArray()->one();
		$query = self::find()
			->joinWith('advert')
			->joinWith('user')
			->joinWith('banner')
			->where([
				'{{%banner_item}}.status' => 1,
				'{{%banner}}.status' => Banner::STATUS_ACTIVE,
				'{{%banner}}.key' => $key,
			]);
		if($statuses['advert']['day_status']){
			$query->andWhere('user.account >= (banner_adv.day_price * banner_adv.day_size)');
		}
		if($statuses['advert']['click_status']){
			$query->andWhere('user.account >= (banner_adv.click_price * banner_adv.click_size)');
		}
		if($statuses['advert']['hit_status']){
			$query->andWhere('user.account >= (banner_adv.hit_price * banner_adv.hit_size)');
		}
		$query->orderBy(['order' => SORT_ASC]);
		return $query;
	}

	/**
	 * Получение эелемента баннера с добавлением рекламодателя и рекламной компании по ID элемента баннера
	 * @param BannerItem $id
	 * @return array|null|ActiveRecord
	 */
	public static function findItemById($id)
	{
		$statuses = self::find()->joinWith('advert')->where(['{{%banner_item}}.status' => 1, '{{%banner_item}}.id'=>$id])->asArray()->one();
		$query = self::find()
			->joinWith('advert')
			->joinWith('user')
			->where([
				'{{%banner_item}}.status' => 1,
				'{{%banner_item}}.id' => $id,
			]);
		if($statuses['advert']['day_status']){
			$query->andWhere('user.account >= (banner_adv.day_price * banner_adv.day_size)');
		}
		if($statuses['advert']['click_status']){
			$query->andWhere('user.account >= (banner_adv.click_price * banner_adv.click_size)');
		}
		if($statuses['advert']['hit_status']){
			$query->andWhere('user.account >= (banner_adv.hit_price * banner_adv.hit_size)');
		}
		$query->orderBy(['order' => SORT_ASC]);
		return $query->one();
	}

	/**
	 * Действие на клик по баннеру
	 * @param BannerItem $id
	 * @return null|static
	 */
	public static function bannerClick($id = null)
	{
		if ($id) {
			$id = base64_decode($id);
			$model = self::findOne($id);
			$model->updateCounters(['click_count' => 1]);
			$model->save();
			$item = self::findItemById($id);
			if($item['advert']['click_status']){
				self::writeOffPerClick($item);
			}
			return $model;
		} else return null;
	}

	public static function writeOffPerClick($item)
	{
		$click = $item['last_click'] + $item['advert']['click_size'];
		if($item['click_count'] >= $click){
			$new_item = self::findOne($item['id']);
			$new_item->last_click = $item['click_count'];
			$new_item->save(false);
			$account = new UserAccount();
			$account->pay_out = $item['advert']['click_price'] * $item['advert']['click_size'];
			$account->id_user = $item['user']['id'];
			$account->invoice = 'ADV-CLICK-' . $item['id'] . '-' . rand(10000, 99999);
			$account->date = new Expression('NOW()');
			$account->description = 'Оплата за '.$item['advert']['click_size'].' переходов(кликов) по ссылке рекламного баннера №' . $item['id'] . '.';
			$account->save(false);
			User::paymentsSumUpdate($item['user']['id']);
		}
	}

	public static function bannerHit(Array $id = null, Array $items = null)
	{
		if (!empty($id)) {
			BannerItem::updateAllCounters(['hit_count' => 1], ['id' => $id]);
			self::writeOffPerHit($items);

		} else return null;
	}

	/**
	 * @param $items
	 */
	public static function writeOffPerHit($items)
	{
		$flag = array();
		foreach ($items as $item){
			if($item['hit_status']){
				$hit = $item['last_hit'] + $item['hit_size'];
				if($item['hit_count'] >= $hit){
					$flag[] = 1;
					$accounts[] = [
						$item['user_id'],
						$item['hit_price'] * $item['hit_size'],
						date('Y-m-d H:i:s'),
						'ADV-HIT-' . $item['id'] . '-' . rand(10000, 99999),
						'Списание за '.$item['hit_size'].' показов рекламного баннера №' . $item['id'] . '.'
					];
					$new_sum_out = $item['sum_out'] + $item['hit_price'] * $item['hit_size'];
					$user_account[] = [
						'user_id' => $item['user_id'],
						'sum_out' => $new_sum_out,
						'account' => $item['sum_in'] - $new_sum_out,
					];
					$last_items[] = [
						'last_hit' => $item['hit_count'],
						'id' => $item['id']
					];
					$items_id[] = $item['id'];
				}
			}
		}
		if(count($flag)>0) {
			$str_ids = implode(',', $items_id);
			$sql = 'UPDATE banner_item SET last_hit = CASE';
			foreach ($last_items as $value){
				$sql .= ' WHEN id = '. $value['id'] . ' THEN ' . $value['last_hit'];
			}
			$sql .= ' END WHERE id IN ('.$str_ids.')';
			Yii::$app->db->createCommand($sql)->execute();
			Yii::$app->db->createCommand()->batchInsert('user_account', ['id_user', 'pay_out', 'date', 'invoice', 'description'], $accounts)->execute();
			Query::usersPayOut($user_account);
		}
	}

	public static function bannerDay(Array $id = null, Array $items = null)
	{
		if (!empty($id)) {
			foreach ($items as $i => $item){
				$day_count = WorkingDates::getDayCountUpNow($item['start']);

				if($day_count > 0 && $item['day_count'] != $day_count){
					$flag[] = $i;
					$day_counts[$i] = [
						'day_count' => $day_count,
						'id' => $item['id'],
					];
					$ids[$i] = $item['id'];
				}
			}
			if(count($flag)>0){
				$str_ids = implode(',', $ids);
				$sql = 'UPDATE banner_item SET day_count = CASE';
				foreach ($day_counts as $value){
					$sql .= ' WHEN id = '. $value['id'] . ' THEN ' . $value['day_count'];
				}
				$sql .= ' END WHERE id IN ('.$str_ids.')';
				Yii::$app->db->createCommand($sql)->execute();
				self::writeOffPerDay($items);
			}
		} else return null;
	}

	public static function writeOffPerDay(Array $items = null)
	{
		if (!empty($items)) {
			$flag = array();
			foreach ($items as $item){
				if($item['day_status']){
					$day = $item['last_day'] + $item['day_size'];
					if($item['day_count'] >= $day){
						$flag[] = 1;
						$accounts[] = [
							$item['user_id'],
							$item['day_price'] * $item['day_size'],
							date('Y-m-d H:i:s'),
							'ADV-DAY-' . $item['id'] . '-' . rand(10000, 99999),
							'Списание за '.$item['day_size'].' дней показов рекламного баннера №' . $item['id'] . '.'
						];
						$new_sum_out = $item['sum_out'] + $item['day_price'] * $item['day_size'];
						$user_account[] = [
							'user_id' => $item['user_id'],
							'sum_out' => $new_sum_out,
							'account' => $item['sum_in'] - $new_sum_out,
						];
						$last_items[] = [
							'last_day' => $item['day_count'],
							'id' => $item['id']
						];
						$items_id[] = $item['id'];
					}
				}
			}
			if(count($flag)>0) {
				$str_ids = implode(',', $items_id);
				$sql = 'UPDATE banner_item SET last_day = CASE';
				foreach ($last_items as $value){
					$sql .= ' WHEN id = '. $value['id'] . ' THEN ' . $value['last_day'];
				}
				$sql .= ' END WHERE id IN ('.$str_ids.')';
				Yii::$app->db->createCommand($sql)->execute();
				Yii::$app->db->createCommand()->batchInsert('user_account', ['id_user', 'pay_out', 'date', 'invoice', 'description'], $accounts)->execute();
				Query::usersPayOut($user_account);
			}
		} else return null;
	}

	/**
	 * @param int $id
	 * @return int|string
	 */
	public static function priceAdvert($id){
		$advert = BannerAdv::findOne($id);
		$day = $advert->day_status ? $advert->day_price * $advert->day_size : 0;
		$hit = $advert->hit_status ? $advert->hit_price * $advert->hit_size : 0;
		$click = $advert->click_status ? $advert->click_price * $advert->click_size : 0;
		return $day + $hit + $click;
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
		return $this->hasOne(User::className(), ['id' => 'id_user']);
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
