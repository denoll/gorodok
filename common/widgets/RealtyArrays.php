<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 12.12.2015
 * Time: 16:51
 */

namespace common\widgets;


class RealtyArrays
{
    public static function homeTypes()
    {
        return [
            ['id'=>'0','name'=>'Кирпичный'],
            ['id'=>'1','name'=>'Монолит'],
            ['id'=>'2','name'=>'Панельный'],
            ['id'=>'3','name'=>'Каркасный'],
            ['id'=>'4','name'=>'Деревянный'],
        ];
    }

    public static function getHomeType($id)
    {
        $type = self::homeTypes();
        return $type[$id]['name'];
    }

    public static function realtyRepair()
    {
        return [
            ['id'=>'0','name'=>'Обычный'],
            ['id'=>'1','name'=>'Евроремонт'],
            ['id'=>'2','name'=>'Дизайнерский'],
            ['id'=>'3','name'=>'Требует ремонта'],
            ['id'=>'4','name'=>'Без отделки'],
            ['id'=>'5','name'=>'Черновая отделка'],
            ['id'=>'6','name'=>'Чистовая отделка'],
        ];
    }
    public static function getRealtyRepair($id)
    {
        $type = self::realtyRepair();
        return $type[$id]['name'];
    }

    public static function realtyResell()
    {
        return [
            ['id'=>'1','name'=>'Новостройка'],
            ['id'=>'0','name'=>'Вторичное жильё'],
        ];
    }
    public static function getRealtyResell($id)
    {
        $type = self::realtyResell();
        return $type[$id]['name'];
    }

    public static function YesNo()
    {
        return [
            ['id'=>'0','name'=>'Нет'],
            ['id'=>'1','name'=>'Есть'],
        ];
    }
    public static function getYesNo($id)
    {
        $type = self::YesNo();
        return $type[$id]['name'];
    }

}