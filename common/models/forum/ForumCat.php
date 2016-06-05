<?php

namespace common\models\forum;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "forum_cat".
 *
 * @property string $id
 * @property string $id_forum
 * @property integer $order
 * @property integer $status
 * @property string $name
 * @property string $alias
 * @property string $created_at
 * @property string $modify_at
 * @property string $description
 * @property string $m_keyword
 * @property string $m_description
 *
 * @property Forums $idForum
 * @property ForumMessage[] $forumMessages
 * @property ForumTheme[] $forumThemes
 */
class ForumCat extends \yii\db\ActiveRecord
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
        return 'forum_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_forum', 'order', 'status'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'modify_at'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 50],
            [['description', 'm_keyword', 'm_description'], 'string', 'max' => 255],
            [['id_forum'], 'exist', 'skipOnError' => true, 'targetClass' => Forums::className(), 'targetAttribute' => ['id_forum' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_forum' => 'Id Forum',
            'order' => 'Порядок',
            'status' => 'Статус',
            'name' => 'Категория',
            'alias' => 'Alias',
            'created_at' => 'Дата создания',
            'modify_at' => 'Дата изменения',
            'description' => 'Описание',
            'm_keyword' => 'Кючевые слова',
            'm_description' => 'мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdForum()
    {
        return $this->hasOne(Forums::className(), ['id' => 'id_forum']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumMessages()
    {
        return $this->hasMany(ForumMessage::className(), ['id_cat' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumThemes()
    {
        return $this->hasMany(ForumTheme::className(), ['id_cat' => 'id']);
    }
}
