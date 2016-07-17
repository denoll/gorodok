<?php

namespace common\models\tags;

use common\models\afisha\Afisha;
use common\models\forum\ForumTheme;
use common\models\letters\Letters;
use common\models\news\News;
use common\models\page\Page;
use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property integer $frequency
 */
class Tags extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'tags';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['status', 'frequency'], 'integer'],
			[['name'], 'string', 'max' => 50],
			[['name'], 'unique'],
			[['name'], \common\components\stopWords\StopWord::className()],
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
			'status' => 'Status',
			'frequency' => 'Frequency',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function items($tag)
	{
		//$query =
	}

	public function getPage()
	{
		return $this->hasMany(Page::className(), ['id' => 'id_page'])
			->viaTable('tags_page', ['id_tag' => 'id']);
	}

	public function getNews()
	{
		return $this->hasMany(News::className(), ['id' => 'id_news'])
			->viaTable('tags_news', ['id_tag' => 'id']);
	}

	public function getAfisha()
	{
		return $this->hasMany(Afisha::className(), ['id' => 'id_afisha'])
			->viaTable('tags_afisha', ['id_tag' => 'id']);
	}

	public function getLetters()
	{
		return $this->hasMany(Letters::className(), ['id' => 'id_letter'])
			->viaTable('tags_letters', ['id_tag' => 'id']);
	}

	public function getForum()
	{
		return $this->hasMany(ForumTheme::className(), ['id' => 'id_forum'])
			->viaTable('tags_forum', ['id_tag' => 'id']);
	}
}
