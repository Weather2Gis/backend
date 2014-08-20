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

    /**
     * Собирает данные с API Yandex
     * @param $city_id индекс города
     * @return array массив с данными
     */
    public static function parse($city_id)
    {
        $data_file = "http://export.yandex.ru/weather-ng/forecasts/$city_id.xml";

        $xml = simplexml_load_file($data_file);

        $map = ['n'  => 1,
                'nw' => 2,
                'w'  => 3,
                'sw' => 4,
                's'  => 5,
                'se' => 6,
                'e'  => 7,
                'ne' => 8,
                'calm' => 9];

        $partofday=[self::MORNING, self::DAY, self::EVENING, self::NIGHT];
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
                        'wind_deg'       => (int)strtr($day->day_part[$part]->wind_direction, $map),
                        'precipitation'   => (string)$day->day_part[$part]->weather_type,
                    ];
            }
        }

        return $array;
    }

}

