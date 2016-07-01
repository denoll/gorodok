<?php

namespace app\modules\forum;

use app\modules\rbac\components\AccessControl;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'app\modules\forum\controllers';

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

	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
