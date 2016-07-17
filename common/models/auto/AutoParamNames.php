<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_param_names".
 *
 * @property integer $id
 * @property string $name
 * @property integer $group_id
 * @property string $units
 * @property integer $item_type
 * @property integer $version
 *
 * @property AutoParamGroups $group
 * @property AutoParams[] $autoParams
 */
class AutoParamNames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_param_names';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'units'], 'string'],
            [['group_id', 'item_type', 'version'], 'integer'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoParamGroups::className(), 'targetAttribute' => ['group_id' => 'id']],
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
            'group_id' => 'Group ID',
            'units' => 'Units',
            'item_type' => 'Item Type',
            'version' => 'Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AutoParamGroups::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoParams()
    {
        return $this->hasMany(AutoParams::className(), ['param_id' => 'id']);
    }
}
