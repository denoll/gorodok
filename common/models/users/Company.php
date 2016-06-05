<?php

namespace common\models\users;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property string $id_user
 * @property string $logo
 * @property string $name
 * @property string $site
 * @property string $email
 * @property string $description
 * @property string $legal_name
 * @property string $address
 * @property string $head
 * @property string $legal_address
 * @property string $accountant
 * @property string $OGRN
 * @property string $INN
 * @property string $OKPO
 * @property string $BIK
 * @property string $BANK
 * @property string $R_S
 * @property string $K_S
 * @property string $created_at
 * @property string $updated_at
 * @property string $m_keyword
 * @property string $m_description
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['logo'], 'string', 'max' => 20],
            [['name', 'head', 'accountant'], 'string', 'max' => 80],
            [['site', 'email'], 'string', 'max' => 50],
            [['legal_name'], 'string', 'max' => 125],
            [['address', 'legal_address', 'BANK', 'm_keyword', 'm_description'], 'string', 'max' => 255],
            [['OGRN'], 'string', 'max' => 15],
            [['INN', 'KPP', 'OKPO', 'BIK'], 'string', 'max' => 10],
            [['R_S', 'K_S'], 'string', 'max' => 14],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['name','legal_name','address', 'legal_address', 'BANK', 'm_keyword', 'm_description','R_S', 'K_S','INN', 'KPP', 'OKPO', 'OGRN', 'BIK', 'head', 'accountant'],'filter','filter'=>'strip_tags']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'logo' => 'Логотип',
            'name' => 'Название компании',
            'site' => 'Сайт',
            'email' => 'Email',
            'description' => 'Описание компании',
            'legal_name' => 'Оф. название (для документов)',
            'address' => 'Физ. адрес',
            'head' => 'Руководитель',
            'legal_address' => 'Юр. адрес',
            'accountant' => 'Гл. бухгалтер',
            'OGRN' => 'ОГРН',
            'INN' => 'ИНН',
            'KPP' => 'КПП',
            'OKPO' => 'ОКПО',
            'BIK' => 'БИК',
            'BANK' => 'БАНК',
            'R_S' => 'Рас/Счет',
            'K_S' => 'Кор/Счет',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата Изменения',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
        ];
    }
}
