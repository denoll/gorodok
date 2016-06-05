<?php

namespace common\models\banners;

use Yii;

/**
 * This is the model class for table "banner_users".
 *
 * @property integer $id
 * @property integer $status
 * @property string $company_name
 * @property string $fio
 * @property string $tel
 * @property string $email
 * @property string $description
 *
 * @property BannerItem[] $bannerItems
 * @property BannerUserAccount[] $bannerUserAccounts
 */
class BannerUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'tel', 'email'], 'required'],
            [['status'], 'integer'],
            [['description'], 'string'],
            [['company_name', 'email'], 'string', 'max' => 50],
            [['fio'], 'string', 'max' => 120],
            [['tel'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
            'company_name' => 'Фирма',
            'fio' => 'ФИО представителя',
            'tel' => 'Телефон',
            'email' => 'Email',
            'description' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerItems()
    {
        return $this->hasMany(BannerItem::className(), ['id_banner_user' => 'id'])->inverseOf('idBannerUser');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerUserAccounts()
    {
        return $this->hasMany(BannerUserAccount::className(), ['id_user' => 'id'])->inverseOf('idUser');
    }
}
