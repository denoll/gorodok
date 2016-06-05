<?php

namespace common\models\letters;

use Yii;
use common\models\users\User;
/**
 * This is the model class for table "letters_rating".
 *
 * @property string $id_letter
 * @property string $id_user
 * @property string $vote_yes
 * @property string $vote_no
 * @property string $date
 *
 * @property Letters $idLetter
 * @property User $idUser
 */
class LettersRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'letters_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_letter', 'id_user'], 'required'],
            [['id_letter', 'id_user','vote_yes','vote_no'], 'integer'],
            [['date'], 'safe'],
            [['id_letter'], 'exist', 'skipOnError' => true, 'targetClass' => Letters::className(), 'targetAttribute' => ['id_letter' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_letter' => 'Id Letter',
            'id_user' => 'Id User',
            'vote_yes' => 'За',
            'vote_no' => 'Против',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLetter()
    {
        return $this->hasOne(Letters::className(), ['id' => 'id_letter']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
