<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 03.02.2016
 * Time: 6:35
 */

namespace common\models;

use \common\models\users\UserAccount;
use common\widgets\Arrays;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\FileHelper;
use common\models\users\User as CurUser;

class CommonQuery extends ActiveRecord
{
	/**
	 * Delete item from catalog.
	 * @param string $item Item model
	 * @param string $img_path
	 * @return mixed
	 */
	public static function deleteItem($item, $img_path = null)
	{
		if ($img_path != null) {
			$dir = Yii::getAlias($img_path);
			if (is_dir($dir)) {
				$images = FileHelper::findFiles($dir, [
					'only' => [
						$item->main_img,
					],
				]);
				for ($n = 0; $n != count($images); $n++) {
					@unlink($images[$n]);
				}
			}
		}
		//delete row from database
		if ($item->delete()) {
			Yii::$app->session->setFlash('success', 'Объявление успешно удалено.');
			return true;
		}else return false;
	}

	/**
	 * Insert Pay in account user.
	 * @param array $request
	 * @return boolean
	 */
	public static function accountPayIn($request)
	{
		if (!empty($request)) {
			$user_id = $request['customerNumber'];
			$model = new UserAccount();
			$model->id_user = $user_id;
			$model->date = date('Y-m-d');
			$model->description = 'Пополнение баланса';
			$model->invoice = $request['orderNumber'];
			$model->pay_in = $request['orderSumAmount'];
			$model->pay_in_with_percent = $request['shopSumAmount'];
			$model->invoiceId = $request['invoiceId'];
			$model->yandexPaymentId = $request['yandexPaymentId'];
			if ($model->save() && self::userAccontUpdateSum($user_id)) {
				$payment = [
					'invoice' => $request['orderNumber'],
					'pay_in' => $request['orderNumber'],
					'date' => date('Y-m-d')
				];
				static::sendPayInEmail($user_id, $payment);
				return true;
			} else return false;
		}
	}
	/**
	 * Update user account payments sum.
	 * @param integer $user_id
	 * @return boolean
	 */
	public static function userAccontUpdateSum($user_id)
	{
		if (CurUser::paymentsSumUpdate($user_id)) {
			Yii::$app->session->setFlash('success', ['value' => 'Баланс успешно обновлен.']);
			return true;
		} else {
			Yii::$app->session->setFlash('danger', ['value' => 'По каким-то причинам баланс пользователя обновить не получилось.<br>Пожалуйста обратитесь к администрации сайта.']);
			return false;
		}
	}

	/**
	 * Send Email for User and Administrator about create user.
	 * @param integer $user_id
	 * @param string|null $password
	 * @return boolean
	 */
	public static function sendCreateUserEmail($user_id, $password = null){
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/createUserEmail', ['current_user' => $current_user , 'password' => $password, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Вы, успешно зарегистрированы на сайте '.Yii::$app->name. '. ')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('На сайте '.Yii::$app->name. '. зарегистрировался новый пользватель: '.$current_user->username.' Email: '.$current_user->email)
			->setHtmlBody('На сайте '.Yii::$app->name. '. зарегистрировался новый пользватель: '.$current_user->username.' Email: '.$current_user->email)
			->send();
	}


	/**
	 * Send Email for User and Administrator about payment in.
	 * @param integer $user_id
	 * @param array $payment ['invoice', 'pay_out', 'data']
	 * @return boolean
	 */
	public static function sendPayInEmail($user_id, $payment){
		$current_user = Yii::$app->user->getIdentity();
		$payment_user = CurUser::findOne($user_id);
		if(!$current_user->id == $user_id){
			$current_user = $payment_user;
		}
		Yii::$app->mailer->compose('@common/mail/payInUserSend', ['current_user' => $current_user ,'payment' => $payment])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Получен новый платеж на сайте '.Yii::$app->name.' №:'.$payment['invoice'])
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Получен новый платеж на сайте '.Yii::$app->name.' №:'.$payment['invoice'])
			->setHtmlBody('Получен новый платеж на сайте '.Yii::$app->name.' №:'.$payment['invoice'].'.<br>На сумму: '. $payment['pay_in'].' руб.<br>От пользователя: '.$current_user->username)
			->send();
	}

	/**
	 * Send Email for User and Administrator about payment in.
	 * @param integer $user_id
	 * @param array $payment ['invoice', 'pay_out', 'account', 'data', 'service', 'description']
	 * @return boolean
	 */
	public static function sendPayOutEmail($user_id, $payment){
		$current_user = Yii::$app->user->getIdentity();
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/payOutUserSend', ['current_user' => $current_user ,'payment' => $payment])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('С Вашего счета на сайте '.Yii::$app->name.' были списаны средства на сумму '.$payment['pay_out'].' рублей.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' получил услугу №:'.$payment['invoice'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' получил услугу по счету №:<strong>'.$payment['invoice'].'</strong>
			<br>На сумму: <strong>'. $payment['pay_out'].' руб.</strong>
			<br>Услуга: '.$payment['service'])
			->send();
	}

	/**
	 * Send Email for User and Administrator about change status ads.
	 * @param integer $user_id
	 * @param array $ads ['id', 'name', 'status', 'data']
	 * @return boolean
	 */
	public static function sendChangeStatusEmail($user_id, $ads, $link){
		$current_user = Yii::$app->user->getIdentity();
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/changeStatusEmail', ['current_user' => $current_user ,'ads' => $ads, 'link'=>$link])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Статус Вашего объявления №: '.$ads['id'].' на сайте '.Yii::$app->name. ' изменен.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' изменил статус объявления №:'.$ads['id'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' изменил статус объявления №:<strong>'.$ads['id'].'</strong>
			<br>На: <strong>'. Arrays::getAdsStatus($ads['status']).'</strong>')
			->send();
	}

	/**
	 * Send Email for User and Administrator about create ads.
	 * @param integer $user_id
	 * @param string $link
	 * @param array $ads ['id', 'name', 'status', 'data']
	 * @return boolean
	 */
	public static function sendCreateAdsEmail($user_id, $ads, $link = null){
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/createAdsEmail', ['current_user' => $current_user ,'ads' => $ads, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Создано новое объявление №: '.$ads['id'].' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' создал новое объявление №:'.$ads['id'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' создал новое объявление №:<strong>'.$ads['id'].'</strong>
			<br>Дата создания: <strong>'. $current_date .'.</strong>')
			->send();
	}

	/**
	 * Send Email for User and Administrator about delete ads.
	 * @param integer $user_id
	 * @param string $link
	 * @param array $ads ['id', 'name', 'status', 'data']
	 * @return boolean
	 */
	public static function sendDeleteAdsEmail($user_id, $ads, $link = null){
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/deleteAdsEmail', ['current_user' => $current_user ,'ads' => $ads, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Ваше объявление №: '.$ads['id'].' на сайте '.Yii::$app->name. ' удалено.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' удалил объявление №:'.$ads['id'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' удалил объявление №:<strong>'.$ads['id'].'</strong>
			<br>Дата удаления: <strong>'. $current_date .'.</strong>')
			->send();
	}

}