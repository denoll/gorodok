<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_params".
 *
 * @property integer $id
 * @property integer $modify_id
 * @property integer $param_id
 * @property string $value
 * @property integer $item_type
 * @property integer $version
 *
 * @property AutoModify $modify
 * @property AutoParamNames $param
 */
class AutoParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modify_id', 'param_id', 'item_type', 'version'], 'integer'],
            [['value'], 'required'],
            [['value'], 'string'],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModify::className(), 'targetAttribute' => ['modify_id' => 'id']],
            [['param_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoParamNames::className(), 'targetAttribute' => ['param_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modify_id' => 'Modify ID',
            'param_id' => 'Param ID',
            'value' => 'Value',
            'item_type' => 'Item Type',
            'version' => 'Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModify()
    {
        return $this->hasOne(AutoModify::className(), ['id' => 'modify_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParam()
    {
        return $this->hasOne(AutoParamNames::className(), ['id' => 'param_id']);
    }
}
