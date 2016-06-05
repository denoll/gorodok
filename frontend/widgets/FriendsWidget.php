<?php
/**
 * Created by PhpStorm.
 * User: denoll
 * Date: 28.08.2015
 * Time: 13:21
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;

class FriendsWidget
{

    public $friends;
    public $friends_count;

    public function __construct()
    {
        $user_id = \Yii::$app->user->id;
        $query = \Yii::$app->db->createCommand(
            'CALL proc_new_friendship_confirm(:id_friend)' //вытаскиваем пользователей которые хотят дружить с текущим пользователем
        );
        $query->bindValue(':id_friend', $user_id);
        $this->friends = $query->queryAll();
        foreach ($this->friends as $friend) {
            $this->friends_count += 1;
        }
    }

    public function show()
    {

        echo '<ul class="dropdown-menu"  role="menu">';
        if ($this->friends) {
            echo '<li class="messages_right_header_top ">Хотят дружить  <span class="msg_count rounded-2x badge-light"> ' . $this->friends_count . ' </span> </li>';
        } else {
            echo '<li class="messages_right_header_top " style="font-size: 0.8em; padding: 5px 0px 5px 10px !important;">Пока нет предложений дружбы</li>';
        }
        foreach ($this->friends as $friend) {
            $path = Url::home() . 'users/profile?id=';
            $u_id = $friend['id_user_initiator'];
            $user = $friend['profile_last_name'] != '' && $friend['profile_first_name'] != '' ? $friend['profile_last_name'] . ' ' . $friend['profile_first_name'] : $friend['username'];
            $avatar_path = Url::home() . 'img/avatars/';
            $ch_avt = $friend['profile_avatar'] != null || $friend['profile_avatar'] != '' ? $avatar_path . 'thumb_' . $friend['profile_avatar'] : $avatar_path . 'setting/avatar.jpg';

            echo '<li>';
            echo '<a href="' . $path . $u_id . '" style="font-size: 0.85em;">';
            echo '<img src="' . $ch_avt . '" style="border-radius: 50% !important; width: 20px; border: 1px solid #ccc; padding: 2px; margin-right:5px;">';
            echo $user;
            echo '</a>';
            echo '</li>';

        }
        echo '</ul>';

    }

}