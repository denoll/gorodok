<?php

namespace common\models\med;

use Yii;
use common\models\users\User;
use \yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "med_doctors".
 *
 * @property string $id_user
 * @property string $id_spec
 * @property integer $status
 * @property integer $confirmed
 * @property string $rank
 * @property string $about
 * @property integer $exp
 * @property integer $receiving
 * @property string $address
 * @property string $updated_at
 * @property string $documents
 * @property string $created_at
 */
class Doctors extends \yii\db\ActiveRecord
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
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
        return 'med_doctors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user','id_spec','price','receiving','rank','exp'],'required'],
            [['id_user', 'id_spec', 'status', 'confirmed', 'exp', 'receiving'], 'integer'],
            [['price'], 'number'],
            [['about'], 'string', 'max' => 250],
            [['updated_at', 'created_at'], 'safe'],
            [['rank', 'address', 'documents','m_keyword','m_description'], 'string', 'max' => 255],
            [['id_spec'], 'exist', 'skipOnError' => true, 'targetClass' => Spec::className(), 'targetAttribute' => ['id_spec' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['rank', 'address', 'documents','about'], 'filter', 'filter' => 'strip_tags'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'id_spec' => 'Специализация',
            'status' => 'Статус',
            'confirmed' => 'Подтвержден',
            'rank' => 'Звание, уч. степень',
            'price' => 'Стоимость приема',
            'about' => 'О себе',
            'exp' => 'Стаж',
            'receiving' => 'Веду прием',
            'address' => 'Адрес для приема',
            'updated_at' => 'Изменен',
            'documents' => 'Документы',
            'created_at' => 'Создан',
        ];
    }
}
