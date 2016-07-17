<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "extensions".
 *
 * @property integer $id
 * @property string $ext_name
 * @property string $category
 * @property string $name
 * @property string $type
 * @property string $url
 * @property integer $status
 */
class Extensions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extensions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ext_name'], 'required'],
            [['status'], 'integer'],
            [['ext_name', 'category', 'name', 'type', 'url'], 'string', 'max' => 150],
            [['var'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ext_name' => 'Расширение',
            'category' => 'Категория',
            'name' => 'Название',
            'type' => 'Тип расширения',
            'var' => 'Переменная',
            'url' => 'Путь',
            'status' => 'Статус',
        ];
    }
}
