<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_param_groups".
 *
 * @property integer $id
 * @property string $name
 * @property integer $version
 *
 * @property AutoParamNames[] $autoParamNames
 */
class AutoParamGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_param_groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['version'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'version' => 'Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoParamNames()
    {
        return $this->hasMany(AutoParamNames::className(), ['group_id' => 'id']);
    }
}
