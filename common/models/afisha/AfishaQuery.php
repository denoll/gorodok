<?php
namespace common\models\afisha;

use creocoder\taggable\TaggableQueryBehavior;


class AfishaQuery extends \yii\db\ActiveQuery
{
	public function behaviors()
	{
		parent::behaviors();
		return [
			TaggableQueryBehavior::className(),
		];
	}

	/**
	 * @return array
	 */
	public function roots()
	{
		return AfishaCat::find()->where(['lvl' => 0, 'active' => 1, 'disabled' => 0, 'visible' => 1])->orderBy('root, lft');
	}
}