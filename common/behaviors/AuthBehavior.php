<?php

namespace common\behaviors;

use yii\base\ActionEvent;
use yii\base\Behavior;
use yii\web\User;

/**
 * @author denoll <denoll@denoll.ru>
 */
class AuthBehavior extends Behavior
{
	/**
	 * @var array
	 */
	public $action;
	/**
	 * @var string
	 */
	public $message = '';


	/**
	 * @inheritdoc
	 */
	public function events(ActionEvent $event)
	{
		$owner = $this->owner;

		if ($owner instanceof \yii\web\Controller && \Yii::$app->user->isGuest) {
			return [
				$owner::EVENT_BEFORE_ACTION => 'checkAccess',
				$owner::EVENT_AFTER_ACTION => 'closeDoor',
			];
		}

		return parent::events();

		if(\Yii::$app->user->isGuest){
			return $this->beforeAction($this->action);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			Yii::$app->user->loginUrl = ['/site/simply-reg'];
			return true;
		} else {
			return false;
		}
	}
}
