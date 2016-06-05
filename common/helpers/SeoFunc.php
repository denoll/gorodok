<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 30.10.2015
 * Time: 2:07
 */

namespace common\helpers;


class SeoFunc
{
    /**
     * Автоматическая генерация keywords на основе данных введенных пользователем.
     * @param array $post
     * @param string $data
     * @return mixed
     */
    public static function generateKeywords($post, $data = null){
        $str = '';
        if($data != null){
            $str .= $data . ', ';
        }
        if(is_array($post) && count($post) > 0 ){
            $str .= implode(', ', $post);
        }
        if($str != ''){
            return strtolower($str);
        }else{
            return false;
        }
    }

    /**
     * Автоматическая генерация Description на основе данных введенных пользователем.
     * @param array $text
     * @param string $data
     * @return mixed
     */
    public static function generateDescription($text, $data = null){
        $str = '';
        if($text != ''){
            $str .= $text . ', ';
        }
        if($data != null){
            $str .= $data ;
        }
        if($str != ''){
            return $str;
        }else{
            return false;
        }
    }
}