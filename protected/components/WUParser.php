<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 15.08.2014
 * Time: 13:08
 */


class WUParser extends CComponent
{

    public function init(){
        return true;
    }

    public static function parse($city)
    {
        //list : утро, день, вечер, ночь
        $list = ["9" => 1, "15" => 2, "21" => 3, "3" => 4];

        $map_weather = [
            'Light Drizzle' => 1,
            'Light Rain' => 1,
            'Light Snow' => 1,
            'Light Snow Grains' => 1,
            'Light Ice Crystals' => 1,
            'Light Ice Pellets' => 1,
            'Light Hail' => 1,
            'Light Mist' => 1,
            'Light Fog' => 1,
            'Light Fog Patches' => 1,
            'Light Smoke' => 1,
            'Light Volcanic Ash' => 1,
            'Light Widespread Dust' => 1,
            'Light Sand' => 1,
            'Light Haze' => 1,
            'Light Spray' => 1,
            'Light Dust Whirls' => 1,
            'Light Sandstorm' => 1,
            'Light Low Drifting Snow' => 1,
            'Light Low Drifting Widespread Dust' => 1,
            'Light Low Drifting Sand' => 1,
            'Light Blowing Snow' => 1,
            'Light Blowing Widespread Dust' => 1,
            'Light Blowing Sand' => 1,
            'Light Rain Mist' => 1,
            'Light Rain Showers' => 1,
            'Light Snow Showers' => 1,
            'Light Snow Blowing Snow Mist' => 1,
            'Light Ice Pellet Showers' => 1,
            'Light Hail Showers' => 1,
            'Light Small Hail Showers' => 1,
            'Light Thunderstorm' => 1,
            'Light Thunderstorms and Rain' => 1,
            'Light Thunderstorms and Snow' => 1,
            'Light Thunderstorms and Ice Pellets' => 1,
            'Light Thunderstorms with Hail' => 1,
            'Light Thunderstorms with Small Hail' => 1,
            'Light Freezing Drizzle' => 1,
            'Light Freezing Rain' => 1,
            'Light Freezing Fog' => 1,
            'Heavy Drizzle' => 1,
            'Heavy Rain' => 1,
            'Heavy Snow' => 1,
            'Heavy Snow Grains' => 1,
            'Heavy Ice Crystals' => 1,
            'Heavy Ice Pellets' => 1,
            'Heavy Hail' => 1,
            'Heavy Mist' => 1,
            'Heavy Fog' => 1,
            'Heavy Fog Patches' => 1,
            'Heavy Smoke' => 1,
            'Heavy Volcanic Ash' => 1,
            'Heavy Widespread Dust' => 1,
            'Heavy Sand' => 1,
            'Heavy Haze' => 1,
            'Heavy Spray' => 1,
            'Heavy Dust Whirls' => 1,
            'Heavy Sandstorm' => 1,
            'Heavy Low Drifting Snow' => 1,
            'Heavy Low Drifting Widespread Dust' => 1,
            'Heavy Low Drifting Sand' => 1,
            'Heavy Blowing Snow' => 1,
            'Heavy Blowing Widespread Dust' => 1,
            'Heavy Blowing Sand' => 1,
            'Heavy Rain Mist' => 1,
            'Heavy Rain Showers' => 1,
            'Heavy Snow Showers' => 1,
            'Heavy Snow Blowing Snow Mist' => 1,
            'Heavy Ice Pellet Showers' => 1,
            'Heavy Hail Showers' => 1,
            'Heavy Small Hail Showers' => 1,
            'Heavy Thunderstorm' => 1,
            'Heavy Thunderstorms and Rain' => 1,
            'Heavy Thunderstorms and Snow' => 1,
            'Heavy Thunderstorms and Ice Pellets' => 1,
            'Heavy Thunderstorms with Hail' => 1,
            'Heavy Thunderstorms with Small Hail' => 1,
            'Heavy Freezing Drizzle' => 1,
            'Heavy Freezing Rain' => 1,
            'Heavy Freezing Fog' => 1,
            'Patches of Fog' => 1,
            'Shallow Fog' => 1,
            'Partial Fog' => 1,
            'Overcast' => 1,
            'Clear' => 3,
            'Partly Cloudy' => 1,
            'Mostly Cloudy' => 1,
            'Scattered Clouds' => 1,
            'Small Hail' => 1,
            'Squalls' => 1,
            'Funnel Cloud' => 1,
            'Unknown Precipitation' => 1,
            'Unknown' => 1,

            'Clear' => 3,
            'Clouds' => 1,
            'Rain' => 2
        ];

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

        $url = "http://api.wunderground.com/api/abf440f8782645dc/hourly10day/conditions/forecast/q/".$city.".xml";
        $xml = simplexml_load_file($url);
        $cityName = $xml->current_observation->display_location->city;
        foreach ($xml->hourly_forecast as $hourly_forecast) {
            foreach($hourly_forecast as $data) {
                /**
                 * @var $data SimpleXMLElement
                 */

                if(!isset($list[(string)$data->FCTTIME->hour])) {
                    continue;
                }

                $array[] = [
                    'name' => $cityName,
                    'date_forecast' => $data->FCTTIME->pretty,
                    'partofday' => $data->FCTTIME->hour,
                    'temp' => $data->temp->metric,
                    'wind_speed' => $data->wspd['metric'],
                    'wind_deg' => $degs[ceil($data->wdir->degrees / 22.5)],
                    'humidity' => $data->humidity,
                    'pressure' => ceil($data->mslp->metric * 0.75),
                    'precipitation_id' => (int)strtr($data->wx, $map_weather)
                ];
            }
        }

        foreach ($array as $data) {
                echo 'имя =                 '.$data['name'].'<br>';
                echo 'дата =                '.$data['date_forecast'].'<br>';
                echo 'час =                 '.$data['partofday'].'<br>';
                echo 'температура =         '.$data['temp'].'<br>';
                echo 'скорость ветра =      '.$data['wind_speed'].'<br>';
                echo 'направление ветра =   '.$data['wind_deg'].'<br>';
                echo 'влажность =           '.$data['humidity'].'<br>';
                echo 'давление =            '.$data['pressure'].'<br>';
                echo 'состояние =           '.$data['precipitation_id'].'<br>';
            }

        return $array;
    }

    public function run(){
        $city_ids = ['Nytva','Barabinsk', 'Novosibirsk'];
        foreach($city_ids as $city) {
            self::parse($city);
        }
    }

}

