<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 17.08.2014
 * Time: 16:57
 */

class ParserIP {
    /**
     * Собирает данные по ip адресу
     * @param $ip ip адрес
     * @return string наименование города
     */
    public static function parse($ip){
        $content = file_get_contents("http://api.sypexgeo.net/json/".$ip);

        $json = json_decode($content, true);

        return $json['city']['name_ru'];
    }
} 