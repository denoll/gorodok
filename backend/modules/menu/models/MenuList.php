<?php

namespace app\modules\menu\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "menu_list".
 *
 * @property string $id
 * @property string $title
 * @property string $alias
 * @property string $position
 * @property integer $status
 */
class MenuList extends ActiveRecord
{

	public function behaviors()
	{
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title',
				'slugAttribute' => 'alias',
				'immutable' => true,
			],
		];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
	        [['title'], 'required'],
            [['title', 'alias'], 'string', 'max' => 50],
            [['position'], 'string', 'max' => 255],
            [['alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID меню',
            'title' => 'Название',
            'alias' => 'Алиас',
            'position' => 'Позиция',
            'status' => 'Статус',
        ];
    }
}
