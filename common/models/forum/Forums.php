<?php

namespace common\models\forum;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "forums".
 *
 * @property string $id
 * @property integer $status
 * @property string $name
 * @property string $alias
 * @property string $created_at
 * @property string $modify_at
 * @property string $description
 * @property string $m_keywords
 * @property string $m_description
 * @property ForumCat[] $forumCats
 * @property ForumMessage[] $forumMessages
 * @property Forums $idParent
 * @property Forums[] $forums
 */
class Forums extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'name',
				'slugAttribute' => 'alias',
				'immutable' => true,
			],
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'modify_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['modify_at'],
				],
				'value' => new Expression('NOW()'),
			],
		];
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status','on_main','order'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'modify_at'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 50],
            [['description', 'm_keywords', 'm_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
	        'on_main'=>'На главной',
            'status' => 'Статус',
	        'order' => 'Порядок',
            'name' => 'Форум',
            'alias' => 'Алиас',
            'created_at' => 'Дата создания',
            'modify_at' => 'Дата изменения',
            'description' => 'Описание',
            'm_keywords' => 'Ключевые слова',
            'm_description' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumCats()
    {
        return $this->hasMany(ForumCat::className(), ['id_forum' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumCatsFront()
    {
        return $this->hasMany(ForumCat::className(), ['id_forum' => 'id'])->andWhere(['status'=>1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumMessages()
    {
        return $this->hasMany(ForumMessage::className(), ['id_forum' => 'id']);
    }
}
