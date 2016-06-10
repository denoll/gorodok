<?php

namespace common\models\jobs;

use Yii;

/**
 * This is the model class for table "v_vacancy".
 *
 * @property string $id_user
 * @property string $username
 * @property string $company_name
 * @property string $email
 * @property string $tel
 * @property string $avatar
 * @property string $name
 * @property string $site
 * @property string $id
 * @property integer $status
 * @property string $title
 * @property string $description
 * @property string $salary
 * @property integer $employment
 * @property string $created_at
 * @property string $updated_at
 * @property string $vip_date
 * @property string $top_date
 * @property string $about_company
 * @property string $address_company
 * @property string $head
 * @property string $search_field
 */
class VVacancy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_vacancy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id', 'status', 'employment'], 'integer'],
            [['username', 'company_name', 'email'], 'required'],
            [['salary'], 'number'],
            [['created_at', 'updated_at', 'vip_date', 'top_date'], 'safe'],
            [['about_company'], 'string'],
            [['username', 'email', 'avatar', 'site'], 'string', 'max' => 50],
            [['tel'], 'string', 'max' => 15],
            [['education'], 'integer'],
            [['name', 'head'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 125],
            [['description', 'address_company'], 'string', 'max' => 255],
            [['search_field'], 'string', 'max' => 499],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'username' => 'Автор',
            'company_name' => 'Компания',
            'email' => 'Email',
            'tel' => 'Телефон',
            'avatar' => 'Аватар',
            'name' => 'Название компании',
            'site' => 'Сайт',
            'id' => 'ID',
            'status' => 'Статус',
            'title' => 'Вакансия',
            'description' => 'Краткое описание',
            'salary' => 'Заработная плата',
            'education' => 'Уровень образования',
            'employment' => 'График работы',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'vip_date' => 'VIP',
            'top_date' => 'На верх',
            'about_company' => 'Описание компании',
            'address_company' => 'Физ. адрес',
            'head' => 'Руководитель',
            'search_field' => 'Search Field',
        ];
    }
}
