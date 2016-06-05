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
	public static  function changeStatus($user_id){
		$user = User::findOne($user_id);
		if($user->status == 10){
			$user->status = 0;
		}else{
			$user->status = 10;
		}
		if($user->save()){
			return $user->status;
		}
	}

}