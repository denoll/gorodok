<?php

namespace common\models\forum;

use common\models\users\AuthAssignment;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\models\users\User;


/**
 * This is the model class for table "forum_message".
 *
 * @property string $id
 * @property string $id_theme
 * @property string $id_cat
 * @property string $id_author
 * @property integer $status
 * @property string $created_at
 * @property string $modify_at
 * @property string $message
 *
 * @property ForumCat $idCat
 * @property ForumTheme $idTheme
 * @property Forums $idForum
 * @property User $idAuthor
 */
class ForumMessage extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
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
        return 'forum_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_theme', 'id_cat', 'id_author'], 'required'],
            [['id_theme', 'id_cat', 'id_author', 'status'], 'integer'],
            [['created_at', 'modify_at'], 'safe'],
            [['message'], 'string'],
            [['message'], 'filter','filter'=>'strip_tags'],
            [['id_cat'], 'exist', 'skipOnError' => true, 'targetClass' => ForumCat::className(), 'targetAttribute' => ['id_cat' => 'id']],
            [['id_theme'], 'exist', 'skipOnError' => true, 'targetClass' => ForumTheme::className(), 'targetAttribute' => ['id_theme' => 'id']],
            [['id_author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_author' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_theme' => 'Id Theme',
            'id_cat' => 'Id Cat',
            'id_author' => 'Id Author',
            'status' => 'Сататус',
            'created_at' => 'Дата сообщения',
            'modify_at' => 'Изменено',
            'message' => 'Сообщение',
        ];
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
    public function getIdTheme()
    {
        return $this->hasOne(ForumTheme::className(), ['id' => 'id_theme']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'id_author']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id_author']);
    }
}
