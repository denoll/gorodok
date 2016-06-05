<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 29.09.2015
 * Time: 17:47
 */

namespace app\modules\rbac\controllers;
use yii\web\Controller as Control;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class Controller extends Control{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['admin'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}
}