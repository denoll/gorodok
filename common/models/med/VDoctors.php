<?php

namespace common\models\med;

use Yii;

/**
 * This is the model class for table "v_doctors".
 *
 * @property string $id_user
 * @property string $id_spec
 * @property integer $status
 * @property integer $confirmed
 * @property string $rank
 * @property string $about
 * @property integer $exp
 * @property integer $receiving
 * @property string $address
 * @property string $updated_at
 * @property string $documents
 * @property string $created_at
 * @property string $username
 * @property string $company_name
 * @property string $email
 * @property string $tel
 * @property string $fio
 * @property string $u_status
 * @property integer $company
 * @property string $avatar
 */
class VDoctors extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'v_doctors';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id_user', 'id_spec', 'status', 'confirmed', 'exp', 'receiving', 'u_status', 'company', 'doctor'], 'integer'],
			[['price'], 'number'],
			[['about'], 'string'],
			[['updated_at', 'created_at'], 'safe'],
			[['rank', 'address', 'documents', 'search_field', 'm_keyword', 'm_description'], 'string', 'max' => 255],
			[['username', 'company_name', 'email', 'avatar', 'spec'], 'string', 'max' => 50],
			[['tel'], 'string', 'max' => 15],
			[['fio'], 'string', 'max' => 152],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id_user' => 'Id User',
			'id_spec' => 'Id Spec',
			'spec' => 'Специальность',
			'price' => 'Стоимость приема',
			'status' => 'Статус',
			'doctor' => 'Доктор',
			'confirmed' => 'Подтверден',
			'rank' => 'Звание, уч. степень',
			'about' => 'О себе',
			'exp' => 'Стаж',
			'receiving' => 'Веду прием',
			'address' => 'Адрес для приема',
			'updated_at' => 'Изменен',
			'documents' => 'Документы',
			'created_at' => 'Создан',
			'email' => 'Email',
			'tel' => 'Телефон',
			'fio' => 'Fio',
			'username' => 'Автор',
			'company_name' => 'Компания',
			'u_status' => 'Статус',
			'company' => 'Как организация',
			'avatar' => 'Аватар',
		];
	}
}
