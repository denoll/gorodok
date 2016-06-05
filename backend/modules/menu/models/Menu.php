<?php

namespace app\modules\menu\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "menu".
 *
 * @property string $id_menu
 * @property string $id
 * @property string $parent
 * @property integer $order
 * @property integer $status
 * @property string $path
 * @property string $alias
 * @property string $title
 * @property string $icon
 * @property string $subtitle
 * @property string $m_keyword
 * @property string $m_description
 */
class Menu extends ActiveRecord
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
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['title'], 'required'],
            [['id_menu', 'parent', 'order', 'status'], 'integer'],
            [['path', 'm_keyword', 'm_description'], 'string', 'max' => 255],
            [['alias', 'title', 'icon', 'subtitle'], 'string', 'max' => 50],
            [['alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_menu' => 'Id Menu',
            'id' => 'ID',
            'parent' => 'Parent',
            'order' => 'Порядок',
            'status' => 'Статус',
            'path' => 'Путь к элементу',
            'alias' => 'Алиас',
            'title' => 'Заголовок',
            'icon' => 'Иконка',
            'subtitle' => 'Подзаоловок',
            'm_keyword' => 'Ключевые слова',
            'm_description' => 'Мета описание',
        ];
    }
}
