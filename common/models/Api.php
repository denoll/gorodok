<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "api".
 *
 * @property string $key
 * @property string $value
 */
class Api extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'string', 'max' => 128],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => 'Ключ',
            'value' => 'Значение',
        ];
    }
}
