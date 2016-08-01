<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 02.06.2016
 * Time: 7:49
 */

namespace common\models\users\clients;

use yii\authclient\OAuth2;

class Odnoklassniki extends OAuth2
{
	/** @inheritdoc */
	public $authUrl = 'http://www.odnoklassniki.ru/oauth/authorize';
	/** @inheritdoc */
	public $tokenUrl = 'http://api.odnoklassniki.ru/oauth/token.do';
	/** @inheritdoc */
	public $apiBaseUrl = 'http://api.odnoklassniki.ru/';
	/** @var string Публичный ключ */
	public $publicKey = 'CBAJCQFLEBABABABA';
	/** @inheritdoc */
	protected function defaultName()
	{
		return 'odnoklassniki';
	}
	/** @inheritdoc */
	protected function defaultTitle()
	{
		return 'Одноклассники';
	}
	/** @inheritdoc */
	protected function initUserAttributes()
	{
		$token = $this->getAccessToken()->getParam('access_token');
		if (!empty($token)) {
			$sig = md5("application_key={$this->publicKey}format=jsonmethod=users.getCurrentUser" . md5("{$token}{$this->clientSecret}"));
			$params = [
				'method'          => 'users.getCurrentUser',
				'access_token'    => $token,
				'application_key' => $this->publicKey,
				'format'          => 'json',
				'sig'             => $sig
			];
		}
		return $this->api('fb.do', 'GET', $params);
	}
	/** @inheritdoc */
	protected function defaultNormalizeUserAttributeMap()
	{
		return [
			'id' => 'uid'
		];
	}
}
