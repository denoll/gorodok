<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_modify".
 *
 * @property integer $id
 * @property string $name
 * @property integer $model_id
 * @property integer $version_id
 * @property integer $y_from
 * @property integer $y_to
 * @property integer $item_type
 * @property integer $version
 *
 * @property AutoItem[] $autoItems
 * @property AutoModels $model
 * @property AutoParams[] $autoParams
 */
class AutoModify extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_modify';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['model_id', 'version_id', 'y_from', 'y_to', 'item_type', 'version'], 'integer'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModels::className(), 'targetAttribute' => ['model_id' => 'id']],
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
            'model_id' => 'Model ID',
            'version_id' => 'Version ID',
            'y_from' => 'Y From',
            'y_to' => 'Y To',
            'item_type' => 'Item Type',
            'version' => 'Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoItems()
    {
        return $this->hasMany(AutoItem::className(), ['id_modify' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModels::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoParams()
    {
        return $this->hasMany(AutoParams::className(), ['modify_id' => 'id']);
    }
}
