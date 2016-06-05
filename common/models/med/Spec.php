<?php

namespace common\models\med;

use Yii;

/**
 * This is the model class for table "med_spec".
 *
 * @property string $id
 * @property string $name
 */
class Spec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'med_spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Специальность',
        ];
    }
}
