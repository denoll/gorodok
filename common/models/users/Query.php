<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.10.2015
 * Time: 6:58
 */

namespace common\models\users;

use \yii\db\ActiveRecord;

class Query extends ActiveRecord
{
	/**
	 * @param $user_id
	 * @return int
	 */
	public static function changeStatus($user_id)
	{
		$user = User::findOne($user_id);
		if ($user->status == User::STATUS_ACTIVE) {
			$user->status = User::STATUS_DELETED;
		} else {
			$user->status = User::STATUS_ACTIVE;
		}
		if ($user->save()) {
			return $user->status;
		}
	}

	/**
	 * Payment in function for one user
	 * @param $user_id
	 * @param string $pay_in
	 * @return bool
	 */
	public static function userPayIn($user_id, $pay_in = null)
	{
		if (empty($user_id)) return false;
		$user = User::findOne($user_id);
		$user->sum_in = $user->sum_in + $pay_in;
		$user->account = $user->sum_in - $user->sum_out;
		if ($user->save()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Payment out function for one user
	 * @param $user_id
	 * @param string $pay_out
	 * @return bool
	 */
	public static function userPayOut($user_id, $pay_out = null)
	{
		if(empty($user_id)) return false;
		$user = User::findOne($user_id);
		$user->sum_out = $user->sum_out + $pay_out;
		$user->account = $user->sum_in - $user->sum_out;
		if ($user->save()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Payment out function for many users
	 * @param array $users
	 * @return bool
	 */
	public static function usersPayOut(Array $users)
	{
		/*echo '<pre>';
		print_r($users);
		echo '</pre>';*/
		if(empty($users)) return false;
		foreach ($users as $user){
			User::paymentsSumUpdate($user['user_id']);
		}

	}

}