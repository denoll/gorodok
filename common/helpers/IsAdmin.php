<?php
namespace common\helpers;


class IsAdmin
{
    /**
     * @var self
     */
    private static $instance;

    public static $show;

    /**
     * Возвращает экземпляр себя
     *
     * @return self
     */
    public static function init()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Конструктор
     */
    private function __construct()
    {
        return self::isAdmin();
    }

    private static function getRole()
    {
        if(!\Yii::$app->user->isGuest){
            $id = \Yii::$app->user->identity->getId();
            return \Yii::$app->authManager->getAssignment('admin',$id);
        }else{
            return null;
        }
    }

    private static function isAdmin(){
        $user = self::getRole();
        if($user->roleName == 'admin' && $user != null){
            $adm = 'admin';
        }else{
            $adm = 'user';
        }
        $ses = \Yii::$app->session;
        $ses->open();
        $ses->set('is_adm', $adm);
        $ses->close();
        self::$show = $adm;
        return $adm;
    }

    /**
     * Клонирование запрещено
     */
    private function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    private function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    private function __wakeup()
    {
    }


}