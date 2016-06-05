<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 08.02.2016
 * Time: 11:49
 */

namespace common\widgets\captcha;

use Yii;
use common\widgets\captcha\Settings;
use common\widgets\captcha\ReCaptcha;

class Captcha
{

	private static $key;
	private static $language;
	private static $secret;
	protected static $_instance;

	public function __construct(){
		self::$key = Settings::SITE_KEY;
		self::$secret = Settings::SECRET_KEY;
		self::$language = Settings::LANG;
	}

	public function init($post){
		if ($post['g-recaptcha-response']!='') {
			$reCaptcha = new ReCaptcha(Settings::SECRET_KEY);
			$resp = $reCaptcha->verifyResponse(
				$_SERVER["REMOTE_ADDR"],
				$post['g-recaptcha-response']
			);
			return $resp;
		}else {
			return false;
		}
	}
	public static function getKey(){
		if (self::$_instance === null) {
			self::$_instance = new self;
		}
		return self::$key;
	}
	public static function getLanguage(){
		if (self::$_instance === null) {
			self::$_instance = new self;
		}
		return self::$language;
	}

}