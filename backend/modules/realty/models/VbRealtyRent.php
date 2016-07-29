<?php

namespace app\modules\realty\models;

use Yii;

/**
 * This is the model class for table "vb_realty_rent".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_cat
 * @property integer $count_img
 * @property string $category
 * @property string $alias
 * @property integer $status
 * @property string $name
 * @property string $address
 * @property string $cost
 * @property string $area_home
 * @property string $area_land
 * @property integer $floor
 * @property integer $floor_home
 * @property integer $resell
 * @property integer $in_city
 * @property string $distance
 * @property integer $repair
 * @property integer $type
 * @property integer $elec
 * @property integer $gas
 * @property integer $water
 * @property integer $heating
 * @property integer $tel_line
 * @property integer $internet
 * @property string $description
 * @property string $vip_date
 * @property string $adv_date
 * @property string $updated_at
 * @property string $created_at
 * @property string $main_img
 * @property string $base_url
 * @property string $m_keyword
 * @property string $m_description
 * @property string $username
 * @property string $company_name
 * @property string $email
 * @property string $tel
 * @property string $fio
 * @property integer $u_status
 * @property integer $company
 * @property string $search_field
 */
class VbRealtyRent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vb_realty_rent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_cat', 'count_img', 'status', 'floor', 'floor_home', 'resell', 'in_city', 'repair', 'type', 'elec', 'gas', 'water', 'heating', 'tel_line', 'internet', 'u_status', 'company'], 'integer'],
            [['cost', 'area_home', 'area_land', 'distance'], 'number'],
            [['description', 'search_field'], 'string'],
            [['vip_date', 'adv_date', 'updated_at', 'created_at'], 'safe'],
            [['category'], 'string', 'max' => 60],
            [['alias'], 'string', 'max' => 70],
            [['name', 'email'], 'string', 'max' => 50],
            [['address', 'main_img', 'base_url', 'm_keyword', 'm_description'], 'string', 'max' => 255],
            [['username', 'company_name'], 'string', 'max' => 80],
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
            'count_img' => 'Count Img',
            'category' => 'Category',
            'alias' => 'Alias',
            'status' => 'Статус',
            'name' => 'Название',
            'address' => 'Адрес',
            'cost' => 'Цена',
            'area_home' => 'Площадь',
            'area_land' => 'Площадь участка',
            'floor' => 'Этаж',
            'floor_home' => 'Этажей в доме',
            'resell' => 'Вторичка',
            'in_city' => 'В городе',
            'distance' => 'До города',
            'repair' => 'Тип оттделки',
            'type' => 'Тип строения',
            'elec' => 'Электричество',
            'gas' => 'Газ',
            'water' => 'Вода',
            'heating' => 'Отопление',
            'tel_line' => 'Телефон',
            'internet' => 'Интернет',
            'description' => 'Описание',
            'vip_date' => 'Выделено',
            'adv_date' => 'Реклама',
            'updated_at' => 'Дата поднятия',
            'created_at' => 'Дата объявления',
            'main_img' => 'Main Img',
            'base_url' => 'Base Url',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
            'username' => 'Логин',
            'company_name' => 'Название компании',
            'email' => 'Email',
            'tel' => 'Телефон',
            'fio' => 'Fio',
            'u_status' => 'Статус',
            'company' => 'Как организация',
            'search_field' => 'Search Field',
        ];
    }
}
