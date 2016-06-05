<?php

namespace common\models\users;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
/**
 * This is the model class for table "user_account".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $pay_in
 * @property string $pay_out
 * @property string $pay_in_with_percent
 * @property string $invoice
 * @property string $date
 * @property string $description
 * @property string $service
 * @property integer $yandexPaymentId
 * @property integer $invoiceId
 * @property string $paymentType
 *
 * @property User $idUser
 */
class UserAccount extends \yii\db\ActiveRecord
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date'],
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
        return 'user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'required'],
            [['id_user'], 'integer'],
            [['pay_in', 'pay_out', 'pay_in_with_percent', 'yandexPaymentId', 'invoiceId'], 'number'],
            [['date'], 'safe'],
            [['invoice'], 'string', 'max' => 32],
            [['description', 'service'], 'string', 'max' => 80],
            [['paymentType'], 'string', 'max' => 4],
            [['invoice'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Пользователь',
            'pay_in' => 'Приход',
            'pay_out' => 'Расход',
            'pay_in_with_percent' => 'Приход(-% комиссия)',
            'invoice' => 'Счет №',
            'date' => 'Дата',
            'description' => 'Информация',
            'service' => 'Услуга',
            'yandexPaymentId' => 'Yandex Payment ID',
            'invoiceId' => 'Invoice ID',
            'paymentType' => 'Тип оплаты',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }


}
