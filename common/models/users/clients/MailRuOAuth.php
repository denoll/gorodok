<?php

namespace common\models\users\clients;

use yii\authclient\OAuth2;

/**
 * MailRuOAuth allows authentication via Mail.ru OAuth.
 *
 * In order to use Mail.ru OAuth you must register your application at <http://api.mail.ru/sites/my/add>.
 *
 * Example application configuration:
 *
 * ```php
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'mailru' => [
 *                 'class' => 'common\models\users\clients\MailRuOAuth',
 *                 'clientId' => 'mailru_app_id',
 *                 'clientSecret' => 'yandex_client_secret',
 *             ],
 *         ],
 *     ]
 *     ...
 * ]
 * ```
 *
 * @see http://api.mail.ru/sites/my/add
 * @see http://api.mail.ru/docs/guides/oauth/standalone/
 *
 * @author Denoll <denoll@denoll.ru>
 * @since 2.0
 */
class MailRuOAuth extends MyOAuth2
{
	/**
	 * @inheritdoc
	 */
	public $authUrl = 'https://connect.mail.ru/oauth/authorize';
	/**
	 * @inheritdoc
	 */
	public $tokenUrl = 'https://connect.mail.ru/oauth/token';
	/**
	 * @inheritdoc
	 */
	public $apiBaseUrl = 'http://www.appsmail.ru';


	/**
	 * @var array list of attribute names, which should be requested from API to initialize user attributes.
	 * @since 2.0.4
	 */
	public $attributeNames = [
		'uid',
		'first_name',
		'last_name',
		'nick',
		'email',
		'sex',
		'birthday'
	];

	/**
	 * @inheritdoc
	 */
	protected function initUserAttributes()
	{
		$accessToken = $this->getAccessToken();
		if (is_object($accessToken)) {
			$accessTokenParams = $accessToken->getParams();
			$params = [
				'method' => 'users.getInfo',
				'app_id' => $this->clientId,
				'secure' => '1',
				'uids' => $accessTokenParams['x_mailru_vid'],
				'session_key' => $accessTokenParams['access_token'],
			];

			$uid = $accessTokenParams['x_mailru_vid'];

			$sign = $this->getSign($params, $uid);

			$get = array_merge($params, ['sig' => md5($sign)]);
/*
			print_r(urldecode(http_build_query($get)));
			echo '<br>'.$sign.'<br>';

			echo '</br>'. $this->privateKey;
			echo '</br>'. md5($sign);
			//exit;
*/

			$response = $this->api('platform/api?'.urldecode(http_build_query($get)),'GET');//, $get);

			$attributes = array_shift($response['response']);
			unset($accessTokenParams['access_token']);
			unset($accessTokenParams['expires_in']);
			$attributes = array_merge($accessTokenParams, $attributes);
		}
		return $attributes;
	}

	protected function getSign($params, $uid)
	{
		//$params['secret_key'] = $this->clientSecret;
		ksort($params);
		$str = '';
		foreach($params as $k => $v){
			$str .= $k .'='.$v;
		}
		return $str . $this->clientSecret;
	}

	/**
	 * @inheritdoc
	 */
	protected function apiInternal($accessToken, $url, $method, array $params, array $headers)
	{
		if (!isset($params['format'])) {
			$params['format'] = 'json';
		}
		$params['oauth_token'] = $accessToken->getToken();
		//print_r($params); exit;
		return $this->sendRequest($method, $url, $params, $headers);
	}

	/**
	 * @inheritdoc
	 */
	protected function defaultName()
	{
		return 'mailru';
	}

	/**
	 * @inheritdoc
	 */
	protected function defaultTitle()
	{
		return 'MailRu';
	}
}
