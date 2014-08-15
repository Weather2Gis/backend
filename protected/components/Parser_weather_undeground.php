<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 15.08.2014
 * Time: 13:08
 */


class Parser_weather_undeground
{
    public static function parse($city)
    {
        //list : утро, день, вечер, ночь
        $list = ["09:00:00" => 1, "15:00:00" => 2, "21:00:00" => 3, "03:00:00" => 4];

        $map_weather = [
            'Clear' => 3,
            'Clouds' => 1,
            'Rain' => 2];

        $degs = [
            0 => 1, 15 => 1, 16 => 1,
            1 => 2, 2 => 2,
            3 => 3, 4 => 3,
            5 => 4, 6 => 4,
            7 => 5, 8 => 5,
            9 => 6, 10 => 6,
            11 => 7, 12 => 7,
            13 => 8, 14 => 8
        ];

        $url = "http://api.wunderground.com/api/abf440f8782645dc/hourly10day/conditions/forecast/q/$city->name_en.xml";
        $xml = simplexml_load_file($url);
        foreach ($xml->response as $response) {

            $array[] = [
                'name' => $response->current_observation->display_location['city'],
            /*    'date_forecast' => $date,
                'partofday' => $list[$partofday],
                'temp' => ceil($time['main']['temp']),
                'wind_speed' => $time['wind']['speed'],
                'wind_deg' => $degs[ceil($time['wind']['deg'] / 22.5)],
                'humidity' => $time['main']['humidity'],
                'pressure' => ceil($time['main']['pressure'] * 0.75),
                'precipitation_id' => (int)strtr($time['weather']['0']['main'], $map_weather)
         */ ];
         print_r($array);
        }

        return $array;
    }

}
$city = ['Moscow','Nytva','Omsk','Barabinsk', 'Novosibirsk','Tomsk'];
parse($city);