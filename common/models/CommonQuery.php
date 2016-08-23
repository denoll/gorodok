<?php
/**
 * Created by denoll.
 * User: Администратор
 * Date: 03.02.2016
 * Time: 6:35
 */

namespace common\models;

use common\helpers\Functions;
use common\models\auto\AutoItem;
use common\models\banners\BannerItem;
use \common\models\users\UserAccount;
use common\widgets\Arrays;
use yii\db\ActiveRecord;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\FileHelper;
use common\models\users\User as CurUser;
use \common\models\konkurs\KonkursItem;
use yii\helpers\Url;

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
				if(!empty($item->main_img)){
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
					'pay_in' => $request['orderSumAmount'],
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
	 * @param array $payment ['invoice', 'pay_in', 'data']
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
	 * Send Email for User and Administrator about change status ads.
	 * @param integer $user_id
	 * @param AutoItem $ads
	 * @return boolean
	 */
	public static function sendChangeAutoStatusEmail($user_id, $ads, $link){
		$current_user = Yii::$app->user->getIdentity();
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/changeAutoStatusEmail', ['current_user' => $current_user ,'ads' => $ads, 'link'=>$link])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Статус Вашего объявления №: '.$ads['id'].' - ' .$ads->brand->name. ' - ' . $ads->model->name .' на сайте '.Yii::$app->name. ' изменен.')
			->send();

		$link_to_ads = Yii::$app->urlManager->createAbsoluteUrl(['/auto/item/view', 'id'=>$ads->id]);
		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' изменил статус объявления №:'.$ads['id'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' изменил статус объявления №:<strong>'.$ads['id'].' - ' .$ads->brand->name. ' - ' . $ads->model->name .'</strong>
			<br>На: <strong>'. \common\models\auto\Arrays::getStatusAuto($ads->status).'</strong>
			<br>Для просмотра объявления пройдите по ссылке: '.Html::a( $link_to_ads ,$link_to_ads )
			)
			->send();
	}

	/**
	 * Send Email for User and Administrator about create ads.
	 * @param integer $user_id
	 * @param string $link
	 * @param AutoItem $ads
	 * @return boolean
	 */
	public static function sendCreateAutoEmail($user_id, $ads, $link = null){
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/createAutoEmail', ['current_user' => $current_user ,'ads' => $ads, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Создано новое о продаже авто объявление №: '.$ads['id'].' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' создал новое объявление о продаже авто №:'.$ads->id)
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' создал новое объявление о продаже авто №:<strong>'.$ads->id.'</strong>
			<br>Автомобиль:<strong>'.$ads->brand->name. ' ' . $ads->model->name . ' - ' . $ads->year .' года выпуска</strong>
			<br>Стоимость:<strong>'.$ads->price. ' руб.</strong>
			<br>Дата создания: <strong>'. $current_date .'.</strong>')
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

	/**
	 * Send Email for User and Administrator about create banner.
	 * @param BannerItem $model
	 * @return boolean
	 */
	public static function sendCreateBannerEmail($model, $link = null){
		$user_id = $model->id_user;
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/createBannerEmail', ['model' => $model, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Создан новый рекламный баннер №: '.$model['id'].' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' создал новый рекламный баннер №:'.$model['id'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' создал новый рекламный баннер №:<strong>'.$model['id'].'</strong>
			<br>Дата создания: <strong>'. $current_date .'.</strong>
			<p>Номер баннера: <strong>'. $model->id .'</strong></p>
			<p>Статус баннера: <strong>'.\common\helpers\Arrays::getStatusBanner($model->status).'</strong></p>
			<p>Рекламная компания баннера: <strong>'. $model->advert->name.'</strong></p>
			<p>Место размещения баннера: <strong>'.$model->banner->name .'</strong></p> 
			<p>Изображение баннера: <div style="display: block;">'. Html::img($model->base_url.'/'.$model->path).'</div></p>')
			->send();
	}

	/**
	 * Send Email for User and Administrator about update status banner.
	 * @param BannerItem $model
	 * @return boolean
	 */
	public static function sendUpdateBannerEmail($model, $link = null){
		$user_id = $model->id_user;
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/updateBannerEmail', ['model' => $model, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Изменен статус Вашего рекламного баннера №: '.$model['id'].' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Рекламный баннер пользователя '.$current_user->username.' №:'.$model['id']. ' изменил свой статус.')
			->setHtmlBody('Рекламный баннер пользователя <strong>'.$current_user->username.'</strong> №: <strong>'.$model['id'].'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' изменил свой статус на: <strong>'.\common\helpers\Arrays::getStatusBanner($model->status).'</strong>
			<br>Дата создания: <strong>'. $current_date .'.</strong>
			<p>Номер баннера: <strong>'. $model->id .'</strong></p>
			<p>Рекламная компания баннера: <strong>'. $model->advert->name.'</strong></p>
			<p>Место размещения баннера: <strong>'.$model->banner->name .'</strong></p> 
			<p>Изображение баннера: <div style="display: block;">'. Html::img($model->base_url.'/'.$model->path).'</div></p>')
			->send();
	}

	/**
	 * Send Email for User and Administrator about delete banner.
	 * @param BannerItem $model
	 * @return boolean
	 */
	public static function sendDeleteBannerEmail($model, $link = null){
		$user_id = $model->id_user;
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if(!$current_user->id == $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/deleteBannerEmail', ['model' => $model, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Удален рекламный баннер №: '.$model['id'].' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' удалил рекламный баннер №:'.$model['id'])
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' удалил рекламный баннер №:<strong>'.$model['id'].'</strong>
			<br>Дата удаления: <strong>'. $current_date .'.</strong>
			<p>Номер баннера: <strong>'. $model->id .'</strong></p>
			<p>Рекламная компания баннера: <strong>'. $model->advert->name.'</strong></p>
			<p>Место размещения баннера: <strong>'.$model->banner->name .'</strong></p>')
			->send();
	}

	/**
	 * Send Email for User and Administrator about create KonkursItem.
	 * @param \common\models\konkurs\KonkursItem $model
	 * @return boolean
	 */
	public static function sendCreateKonkursItemEmail($model, $link = null){

		$user_id = $model->id_user;
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if($current_user->id != $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/createKonkursItemEmail', ['model' => $model, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Поздравляем, Вы приняли участие в конкурсе: '.$model->konkurs->name.' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Пользователь '.$current_user->username.' на сайте '.Yii::$app->name.' создал новый элемент в конкурсе:'.$model->konkurs->name)
			->setHtmlBody('Пользователь <strong>'.$current_user->username.'</strong>
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>На сайте '.Yii::$app->name.' создал новый элемент в конкурсе:<strong>'.$model->konkurs->name.'</strong>
			<br>Дата создания: <strong>'. $current_date .'.</strong>
			<p>Название элемента: <strong>'. $model->name .'</strong></p>
			<p>Статус элемента: <strong>'. KonkursItem::getCurStatus($model->status).'</strong></p>
			<p>Изображение: <div style="display: block;">'. Html::img($model->base_url.'/'.$model->img).'</div></p>
			<h3>Текст:</h3>
			<p>'. nl2br($model->description) .'</p>
			')
			->send();
	}

	/**
	 * Send Email for User and Administrator about update status KonkursItem.
	 * @param \common\models\konkurs\KonkursItem $model
	 * @return boolean
	 */
	public static function sendUpdateKonkursItemEmail($model, $link = null){
		$user_id = $model->id_user;
		$current_user = Yii::$app->user->getIdentity();
		$current_date = Yii::$app->formatter->asDate(date("Y-m-d H:i:s"));
		if($current_user->id != $user_id){
			$current_user = CurUser::findOne($user_id);
		}
		Yii::$app->mailer->compose('@common/mail/updateKonkursItemEmail', ['model' => $model, 'link'=>$link, 'date'=> $current_date])
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo($current_user->email)
			->setSubject('Изменен статус Вашего элемента '.$model->name.' в конкурсе: '.$model->konkurs->name.' на сайте '.Yii::$app->name. '.')
			->send();

		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->params['robotEmail'])
			->setTo(Yii::$app->params['adminEmail'])
			->setSubject('Статус элемента '.$model->name.' пользователя '.$current_user->username.' в конкурсе: '.$model->konkurs->name. ' изменил свой статус.')
			->setHtmlBody('Статус элемента <strong>'.$model->name.'</strong> пользователя <strong>'.$current_user->username.'</strong> в конкурсе: <strong>'.$model->konkurs->name. '</strong> изменил свой статус.
			<br><strong>Email: '.$current_user->email.'</strong>
			<br>Конкурс:<strong>'.$model->konkurs->name.'</strong>
			<p>Название элемента: <strong>'. $model->name .'</strong></p>
			<p>Текущий статус элемента: <strong>'. KonkursItem::getCurStatus($model->status).'</strong></p>
			<br>Дата изменения: <strong>'. $current_date .'.</strong>
			<p>Изображение: <div style="display: block;">'. Html::img($model->base_url.'/'.$model->img).'</div></p>
			<h3>Текст:</h3>
			<p>'. nl2br($model->description) .'</p> 
			')
			->send();
	}

}
