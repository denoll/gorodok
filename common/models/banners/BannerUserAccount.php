<?php

namespace common\models\banners;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
/**
 * This is the model class for table "banner_user_account".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_advert
 * @property integer $id_item
 * @property string $pay_in
 * @property string $pay_out
 * @property string $invoice
 * @property string $date
 * @property string $description
 * @property string $service
 *
 * @property BannerUsers $idUser
 */
class BannerUserAccount extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at', 'date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
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
        return 'banner_user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user','id_advert','id_item'], 'integer'],
            [['invoice','id_user'], 'required'],
            [['pay_in', 'pay_out'], 'number'],
            [['date','created_at','updated_at'], 'safe'],
            [['invoice'], 'string', 'max' => 32],
            [['description', 'service'], 'string', 'max' => 80],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => BannerUsers::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Рекламодатель',
            'id_advert' => 'Рекламная компания',
            'id_item' => 'Рекламный баннер',
            'pay_in' => 'Приход',
            'pay_out' => 'Расход',
            'invoice' => 'Счет №',
            'date' => 'Дата',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'description' => 'Информация',
            'service' => 'Услуга',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(BannerUsers::className(), ['id' => 'id_user'])->inverseOf('bannerUserAccounts');
    }
}
