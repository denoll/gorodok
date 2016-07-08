<?php

namespace common\models\firm;

use Yii;

/**
 * This is the model class for table "v_firm".
 *
 * @property integer $id
 * @property integer $id_cat
 * @property integer $id_user
 * @property integer $status
 * @property integer $show_requisites
 * @property string $name
 * @property string $tel
 * @property string $email
 * @property string $site
 * @property string $logo
 * @property string $base_url
 * @property string $description
 * @property string $address
 * @property string $lat
 * @property string $lon
 * @property string $mk
 * @property string $updated_at
 * @property string $md
 * @property string $created_at
 * @property string $cat_slug
 * @property string $cat_name
 */
class VFirm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_firm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cat', 'id_user', 'status', 'show_requisites'], 'integer'],
            [['description'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['tel', 'email', 'site', 'logo', 'base_url', 'address', 'mk', 'md', 'cat_slug'], 'string', 'max' => 255],
            [['lat', 'lon'], 'string', 'max' => 30],
            [['cat_name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Категория',
            'id_user' => 'Пользователь',
            'status' => 'Статус',
            'show_requisites' => 'Показывать реквизиты',
            'name' => 'Название компании',
            'tel' => 'Телефон',
            'email' => 'Email',
            'site' => 'Сайт',
            'logo' => 'Логотип',
            'base_url' => 'Base Url',
            'description' => 'Описание',
            'address' => 'Адрес',
            'lat' => 'Широта',
            'lon' => 'Долгота',
            'mk' => 'Ключевые слова',
            'updated_at' => 'Дата изменения',
            'md' => 'Мета описание',
            'created_at' => 'Дата создания',
            'cat_slug' => 'Алиас',
            'cat_name' => 'Категория',
        ];
    }
}
