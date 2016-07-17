<?php

namespace common\models\auto;

use Yii;

/**
 * This is the model class for table "auto_versions".
 *
 * @property integer $id
 * @property string $name
 * @property string $gen
 * @property string $mod
 * @property integer $model_id
 * @property integer $item_type
 * @property integer $version
 *
 * @property AutoModels $model
 */
class AutoVersions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_versions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'gen', 'mod'], 'string'],
            [['gen', 'mod'], 'required'],
            [['model_id', 'item_type', 'version'], 'integer'],
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
            'gen' => 'Gen',
            'mod' => 'Mod',
            'model_id' => 'Model ID',
            'item_type' => 'Item Type',
            'version' => 'Version',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModels::className(), ['id' => 'model_id']);
    }
}
