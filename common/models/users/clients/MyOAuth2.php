<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 02.06.2016
 * Time: 6:21
 */

namespace common\models\users\clients;


use yii\authclient\OAuth2;

class MyOAuth2 extends OAuth2
{
	/**
	 * @var string OAuth client secret.
	 */
	public $privateKey;
}