<?php

namespace common\models\med;

use Yii;

/**
 * This is the model class for table "med_service".
 *
 * @property string $id
 * @property string $id_user
 * @property integer $status
 * @property string $name
 * @property string $cost
 * @property string $description
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'med_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'status'], 'integer'],
            [['cost'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Doctors::className(), 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'status' => 'Статус',
            'name' => 'Мед. услуга',
            'cost' => 'Стоимость',
            'description' => 'Описание услуги',
        ];
    }
}
