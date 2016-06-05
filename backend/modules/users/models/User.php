<?php

namespace app\modules\users\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $patronym
 * @property integer $confirmed_at
 * @property integer $blocked_at
 * @property string $status
 * @property string $created_at
 * @property integer $updated_at
 * @property integer $rating
 * @property integer $flags
 * @property string $lat
 * @property string $long
 * @property string $ip
 * @property string $avatar
 * @property integer $count_fm
 * @property integer $count_ft
 * @property string $auth_key
 * @property string $password_hash
 *
 * @property SocialAccount[] $socialAccounts
 * @property Token[] $tokens
 */
class User extends \yii\db\ActiveRecord
{

    public $old_password;
    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'rating', 'count_fm', 'count_ft'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['username'], 'string', 'min' => 4, 'max' => 255],
            [['name', 'surname', 'patronym', 'lat', 'long', 'avatar'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 45],
	        [['flags'], 'string', 'max' => 5],
            [['auth_key'], 'string', 'max' => 32],
            [['country','region','city','password_hash'], 'string', 'max' => 60],
            [['email'], 'email', 'message' => 'Это не похоже на e-mail адрес.'],
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username','email','password',], 'filter', 'filter' => 'strip_tags'],
            [['username', 'email'], 'required'],
            [['username', 'email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Email',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronym' => 'Отчество',
            'confirmed_at' => 'Дата подтверждения',
            'blocked_at' => 'Дата блокировки',
            'status' => 'Статус',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата изменения',
            'rating' => 'Рейтинг',
            'flags' => 'Флаг',
	        'country' => 'Страна',
	        'region' => 'Регион',
	        'city' => 'Нас. пункт (город или др.)',
            'lat' => 'Широта',
            'long' => 'Долгота',
            'ip' => 'IP адрес',
            'avatar' => 'Аватар',
            'count_fm' => 'Написал сообщений на форуме',
            'count_ft' => 'Создал тем на форуме',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
        ];
    }


    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setNewPassword($new_password)
    {
        try{
            $this->password_hash = Yii::$app->security->generatePasswordHash($new_password);
            return true;
        }catch (InvalidParamException $e){
            print_r($e);
            return false;
        }
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
