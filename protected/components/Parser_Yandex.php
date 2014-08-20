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
     * Прогноз погоды с сервиса yandex
     * @param $city_id идентификатор города
     * @return array массив со всеми нужными параметрами погоды на один город
     */
    public static function parse($city_id)
    {
        $data_file = "http://export.yandex.ru/weather-ng/forecasts/$city_id.xml"; // адрес xml файла

        $xml = simplexml_load_file($data_file); // раскладываем xml на массив

        $map_weather = [
            'clear'     => 3,
            'cloudy'    => 1,
            'rain'      => 2,
            'overcast'  => 1,
        'overcast-and_rain'=>2,
        'partly-cloudy-and-light-rain'=>2,
        'partly-cloudy'=>1,
        'overcast-and-light-rain'=>2,
        'cloudy-and-light-rain'=>2,
        'mostly-clear'=>3];

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
                        'date_forecast' =>(string)$day['date'],
                        'partofday' => (int)$part,
                        'name'      => $xml['city'],
                        'temp'      => (int)$day->day_part[$part]->$str->avg,
                        'wind_speed'    => (float)$day->day_part[$part]->wind_speed,
                        'humidity'  => (int)$day->day_part[$part]->humidity,
                        'pressure'  => (int)$day->day_part[$part]->pressure,
                        'wind_deg'       => (int)strtr($day->day_part[$part]->wind_direction, $map),
                        'precipitation_id'   => (int)strtr($day->day_part[$part]->weather_condition['code'], $map_weather)
                    ];
            }
        }

        return $array;
    }

}

