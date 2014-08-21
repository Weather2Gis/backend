<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 12.08.2014
 * Time: 12:59
 */

class Parser_Yandex implements IProvider
{

    public static $errors;

    const MORNING = 0;
    const DAY = 1;
    const EVENING = 2;
    const NIGHT = 3;

    /**
     * Путь покоторому запрашиваем данные
     */
    public static $url = "http://export.yandex.ru/weather-ng/forecasts/";

    /**
     * Возвращает путь по которому запрашиваем данные
     */
    protected static function getUrl($city_id)
    {
        return self::$url . $city_id . '.xml';
    }

    /**
     * Собирает данные с API Yandex
     * @param $city_id индекс города
     * @return array|false массив с данными о погоде|false если ошибка
     */
    public static function parse($city_id)
    {
        self::$errors = [];

        $url = self::getUrl($city_id);

        libxml_use_internal_errors(false);

        $xml = simplexml_load_file($url);

        if (!$xml) {
            self::$errors = libxml_get_errors();
            return false;
        }

        $map = [
            'n'  => 1,
            'nw' => 2,
            'w'  => 3,
            'sw' => 4,
            's'  => 5,
            'se' => 6,
            'e'  => 7,
            'ne' => 8,
            'calm' => 9
        ];

        $partofday = [self::MORNING, self::DAY, self::EVENING, self::NIGHT];
        $str = "temperature-data";
        foreach ($xml->day as $day) {
            foreach ($partofday as $part) {
                $array[] = [
                        'date_forecast' =>  (string)$day['date'],
                        'partofday'     =>  (int)$part + 1,
                        'name'          =>  $xml['city'],
                        'temp'          =>  (int)$day->day_part[$part]->$str->avg,
                        'wind_speed'    =>  (float)$day->day_part[$part]->wind_speed,
                        'humidity'      =>  (int)$day->day_part[$part]->humidity,
                        'pressure'      =>  (int)$day->day_part[$part]->pressure,
                        'wind_deg'      =>  (int)strtr($day->day_part[$part]->wind_direction, $map),
                        'precipitation' =>  (string)$day->day_part[$part]->weather_type,
                    ];
            }
        }

        return $array;
    }
}
