<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 12.08.2014
 * Time: 12:59
 */

class Parser_Yandex
{
    const MORNING = 0;
    const DAY = 1;
    const EVENING = 2;
    const NIGHT = 3;

    public static function parse($city_id)
    {
        $data_file = "http://export.yandex.ru/weather-ng/forecasts/$city_id.xml"; // адрес xml файла

        $xml = simplexml_load_file($data_file); // раскладываем xml на массив

        $map = ['n'  => 1,
                'nw' => 2,
                'w'  => 3,
                'sw' => 4,
                's'  => 5,
                'se' => 6,
                'e'  => 7,
                'ne' => 8];

        $str = 'temperature-data';

        $partofday=[self::MORNING, self::DAY, self::EVENING, self::NIGHT];

        foreach ($xml->day as $day) {
            foreach ($partofday as $part) {
                $array[] = [
                        'date_forecast' =>( string)$day['date'],
                        'partofday' => $part,
                        'name'      => $xml['city'],
                        'temp'      => $day->day_part[$part]->$str->avg,
                        'speed'     => $day->day_part[$part]->wind_speed,
                        'humidity'  => $day->day_part[$part]->humidity,
                        'pressure'  => $day->day_part[$part]->pressure,
                        'deg'       => strtr($day->day_part[$part]->wind_direction,$map),
                        'weather'   => $day->day_part[$part]->weather_type
                    ];
            }
        }

        return $array;
    }

}

