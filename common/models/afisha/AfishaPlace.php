<?php

namespace common\models\afisha;

use Yii;

/**
 * This is the model class for table "afisha_place".
 *
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $description
 *
 * @property Afisha[] $afishas
 */
class AfishaPlace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'afisha_place';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
            'description' => 'Описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAfishas()
    {
        return $this->hasMany(Afisha::className(), ['id_place' => 'id']);
    }
}
