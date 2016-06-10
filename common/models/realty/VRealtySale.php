<?php

namespace common\models\realty;

use Yii;

/**
 * This is the model class for table "v_realty_sale".
 *
 * @property string $id
 * @property string $id_user
 * @property string $id_cat
 * @property string $category
 * @property string $alias
 * @property integer $status
 * @property string $name
 * @property string $cost
 * @property string $area_home
 * @property string $area_land
 * @property integer $floor
 * @property integer $floor_home
 * @property integer $resell
 * @property integer $in_city
 * @property string $distance
 * @property string $description
 * @property string $vip_date
 * @property string $adv_date
 * @property string $updated_at
 * @property string $created_at
 * @property string $main_img
 * @property string $m_keyword
 * @property string $m_description
 * @property string $username
 * @property string $company_name
 * @property string $email
 * @property string $tel
 * @property string $fio
 * @property string $u_status
 * @property integer $company
 * @property string $search_field
 */
class VRealtySale extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'v_realty_sale';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'id_user', 'id_cat', 'status', 'floor', 'floor_home', 'resell', 'in_city', 'u_status', 'company', 'type', 'gas', 'water', 'heating', 'tel_line', 'internet', 'count_img'], 'integer'],
			[['cost', 'area_home', 'area_land', 'distance'], 'number'],
			[['description', 'search_field'], 'string'],
			[['vip_date', 'adv_date', 'updated_at', 'created_at'], 'safe'],
			[['category'], 'string', 'max' => 60],
			[['alias'], 'string', 'max' => 70],
			[['name', 'company_name', 'username', 'email'], 'string', 'max' => 80],
			[['main_img', 'm_keyword', 'm_description'], 'string', 'max' => 255],
			[['tel'], 'string', 'max' => 15],
			[['fio'], 'string', 'max' => 152],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'Номер объявления',
			'id_user' => 'Пользователь',
			'id_cat' => 'Категория',
			'category' => 'Category',
			'alias' => 'Alias',
			'status' => 'Статус',
			'name' => 'Название',
			'cost' => 'Цена',
			'area_home' => 'Площадь',
			'area_land' => 'Площадь участка',
			'floor' => 'Этаж',
			'floor_home' => 'Этажей в доме',
			'resell' => 'Вторичка',
			'in_city' => 'В городе',
			'distance' => 'До города',
			'description' => 'Описание',
			'vip_date' => 'Выделено',
			'adv_date' => 'Реклама',
			'updated_at' => 'Дата поднятия',
			'created_at' => 'Дата объявления',
			'main_img' => 'Изображение',
			'm_keyword' => 'Ключевые слова',
			'm_description' => 'Мета описание',
			'username' => 'Автор',
			'company_name' => 'Компания',
			'email' => 'Email',
			'tel' => 'Телефон',
			'fio' => 'ФИО',
			'u_status' => 'Статус пользователя',
			'company' => 'Как организация',
			'search_field' => 'Search Field',
		];
	}
}
