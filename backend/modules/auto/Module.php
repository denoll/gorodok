<?php

namespace app\modules\auto;

use Yii;
use app\modules\rbac\components\AccessControl;

/**
 * auto module definition class
 */
class Module extends \yii\base\Module
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'app\modules\auto\controllers';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'denyCallback' => function ($rule, $action) {
					return $action->controller->redirect(\Yii::getAlias('@frt_url'));
				},
				'rules' => [
					[
						'allow' => true,
						'roles' => ['admin'],
					],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
