<?php

namespace common\models\goods;

use Yii;
use common\models\tags\Tags;
/**
 * This is the model class for table "v_goods".
 *
 * @property string $id_user
 * @property string $id_cat
 * @property string $cat
 * @property integer $status
 * @property string $name
 * @property string $cost
 * @property string $description
 * @property string $vip_date
 * @property string $top_date
 * @property string $updated_at
 * @property string $created_at
 * @property string $main_img
 * @property string $m_keyword
 * @property string $m_description
 * @property string $username
 * @property string $email
 * @property string $tel
 * @property string $fio
 * @property string $u_status
 * @property integer $company
 * @property string $search_field
 */
class VGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_cat', 'status', 'u_status', 'company'], 'integer'],
            [['cost'], 'number'],
            [['description', 'search_field'], 'string'],
            [['vip_date', 'top_date', 'updated_at', 'created_at'], 'safe'],
            [['category', 'alias'], 'string', 'max' => 65],
            [['name', 'main_img', 'username', 'email'], 'string', 'max' => 50],
            [['m_keyword', 'm_description'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 15],
            [['fio'], 'string', 'max' => 152],
            [['tel','description','name', 'main_img', 'username', 'email', 'category', 'alias'],'filter', 'filter'=>'strip_tags'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'id_cat' => 'Id Cat',
            'category' => 'Категория',
            'status' => 'Статус',
            'name' => 'Товар',
            'cost' => 'Цена',
            'description' => 'Описание',
            'vip_date' => 'Дата VIP ',
            'top_date' => 'Дата поднятия',
            'updated_at' => 'Изменено',
            'created_at' => 'Создано',
            'main_img' => 'Main Img',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
            'username' => 'Логин',
            'email' => 'Email',
            'tel' => 'Телефон',
            'fio' => 'Fio',
            'u_status' => 'Статус',
            'company' => 'Как организация',
            'search_field' => 'Search Field',
        ];
    }
    /**
     * @inheritdoc
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_goods',['id_goods'=>'id']);
    }
}
