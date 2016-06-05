<?php
/**
 * Created by PhpStorm.
 * User: denoll
 * Date: 26.08.2015
 * Time: 3:20
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;


class ChatsWidget extends \yii\bootstrap\Widget
{
    var $count_new_message;
    var $place;
    var $chats;

    public function __construct($place = null)
    {
        $user_id = \Yii::$app->user->id;
        if ($place == null) {
            $query = \Yii::$app->db->createCommand(
                'CALL proc_get_all_chats_on_user(:sender)' // вытаскиваем всю переписку текущего пользователи и его собеседника
            );
            $query->bindValue(':sender', $user_id);
            $this->chats = $query->queryAll();

        } elseif ($place == 'top') {
            //proc_get_chats_new_messages
            $query = \Yii::$app->db->createCommand(
                'CALL proc_get_chats_new_messages(:sender)' // вытаскиваем новую переписку текущего пользователи и его собеседника
            );
            $query->bindValue(':sender', $user_id);
            $this->chats = $query->queryAll();
            foreach ($this->chats as $chat) {
                $this->count_new_message += $chat['new_message'];
            }
        }
        $this->place = $place;
    }

    public function show()
    {
        if ($this->place == null) {
            if (is_array($this->chats)) {
                echo '<ul class="list-group sidebar-nav-v1 margin-bottom-40" id="sidebar-nav-right">';
                echo '<li class="list-group-item messages_right_header ">Вся переписка</li>';
                foreach ($this->chats as $chat) {
                    $path = Url::home() . 'users/messages?id=';
                    $u_id = $chat['sender'] == Yii::$app->user->id ? $chat['id_user_in'] : $chat['sender'];
                    $user = $chat['profile_last_name'] != '' && $chat['profile_first_name'] != '' ? $chat['profile_last_name'] . ' ' . $chat['profile_first_name'] : $chat['username'];
                    $avatar_path = Url::home() . 'img/avatars/';
                    $ch_avt = $chat['profile_avatar'] != null || $chat['profile_avatar'] != '' ? $avatar_path . 'thumb_' . $chat['profile_avatar'] : $avatar_path . 'setting/avatar.jpg';


                    echo '<li class="list-group-item">';
                    echo '<a href="' . $path . $u_id . '" style="font-size: 0.85em;">';
                    echo '<img src="' . $ch_avt . '" style="border-radius: 50% !important; width: 20px; border: 1px solid #ccc; padding: 2px; margin-right:5px;">';
                    echo $user;
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
        } elseif ($this->place == 'top') {
            if (is_array($this->chats)) {
                echo '<ul class="dropdown-menu"  role="menu">';
                if ($this->count_new_message > 0) {
                    echo '<li class="messages_right_header_top ">Новые сообщения  <span class="msg_count rounded-2x badge-light">' . $this->count_new_message . '</span> </li>';
                } else {
                    echo '<li class="messages_right_header_top" style="font-size: 0.8em; padding: 5px 0px 5px 10px !important;">Новых сообщений нет</li>';
                }
                foreach ($this->chats as $chat) {
                    $path = Url::home() . 'users/messages?id=';
                    $u_id = $chat['sender'] == Yii::$app->user->id ? $chat['id_user_in'] : $chat['sender'];
                    $user = $chat['profile_last_name'] != '' && $chat['profile_first_name'] != '' ? $chat['profile_last_name'] . ' ' . $chat['profile_first_name'] : $chat['username'];
                    $avatar_path = Url::home() . 'img/avatars/';
                    $ch_avt = $chat['profile_avatar'] != null || $chat['profile_avatar'] != '' ? $avatar_path . 'thumb_' . $chat['profile_avatar'] : $avatar_path . 'setting/avatar.jpg';

                    echo '<li>';
                    echo '<a href="' . $path . $u_id . '" style="font-size: 0.85em;">';
                    echo '<img src="' . $ch_avt . '" style="border-radius: 50% !important; width: 20px; border: 1px solid #ccc; padding: 2px; margin-right:5px;">';
                    echo $user . '   <span class="msg_count rounded-2x badge-light">' . $chat['new_message'] . '</span>';
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
        }
    }
}