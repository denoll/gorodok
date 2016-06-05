<?php

namespace common\models\forum;

use common\models\tags\TagsForum;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use creocoder\taggable\TaggableBehavior;
use yii\db\Expression;
use common\models\users\User;
use common\models\tags\Tags;
/**
 * This is the model class for table "forum_theme".
 *
 * @property string $id
 * @property string $id_cat
 * @property string $id_author
 * @property integer $status
 * @property integer $order
 * @property integer $to_top
 * @property string $name
 * @property string $alias
 * @property string $created_at
 * @property string $modify_at
 * @property string $description
 * @property string $m_keyword
 * @property string $m_description
 *
 * @property ForumMessage[] $forumMessages
 * @property ForumCat $idCat
 * @property User $idAuthor
 */
class ForumTheme extends ActiveRecord
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
            'taggable' => [
                'class' => TaggableBehavior::className(),
                'tagValuesAsArray' => true,
                'tagRelation' => 'tags',
                'tagValueAttribute' => 'name',
                'tagFrequencyAttribute' => 'frequency',
            ],
		];
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forum_theme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['tagValues', 'validateTagsCount'],
            [['id_cat', 'id_author', 'views', 'message_count', 'status', 'order', 'to_top'], 'integer'],
            [['created_at', 'modify_at', 'tagValues'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 125],
            [['description'], 'string', 'max' => 4000],
            [['m_keyword', 'm_description'], 'string', 'max' => 255],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ForumCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
        ];
    }

    public function validateTagsCount()
    {
        $tagsCount = TagsForum::find()->select('Count(*) AS count')->where(['id_forum'=>$this->id])->asArray()->one();
        $post = Yii::$app->request->post('ForumTheme');
        if ($tagsCount['count'] > 3 ||count($post['tagValues']) > 3) {
            Yii::$app->session->setFlash('danger', 'Разрешенное максимальное кол-во тегов 3 штуки! (Сократите теги до трех штук).');
            $this->addError('tagValues', 'Разрешенное максимальное кол-во тегов 3 штуки! (Сократите теги до трех штук).');
            return false;
        }else{
            return true;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cat' => 'Id Cat',
            'id_author' => 'Id Author',
	        'views' => 'Просмотров',
	        'message_count' => 'Кол-во сообщений',
            'status' => 'Статус',
            'order' => 'Порядок',
            'to_top' => 'Прикрепить с верху',
            'name' => 'Тема',
            'alias' => 'Alias',
            'created_at' => 'Дата создания',
            'modify_at' => 'Дата изменения',
            'description' => 'Описание',
            'm_keyword' => 'Ключеые слова',
            'm_description' => 'Мета описание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function find()
    {
        return new ForumQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('tags_forum',['id_forum'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumMessages()
    {
        return $this->hasMany(ForumMessage::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCat()
    {
        return $this->hasOne(ForumCat::className(), ['id' => 'id_cat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'id_author']);
    }
}
