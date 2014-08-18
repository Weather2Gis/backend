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

        Yii::t('app', 'Light Dri');
        Yii::t('app', 'Light Rain');
        Yii::t('app', 'Light Snow');
        Yii::t('app', 'Light Snow Grains');
        Yii::t('app', 'Light Ice Crystals');
        Yii::t('app', 'Light Ice Pellets');
        Yii::t('app', 'Light Hail');
        Yii::t('app', 'Light Mist');
        Yii::t('app', 'Light Fog');
        Yii::t('app', 'Light Fog Patches');
        Yii::t('app', 'Light Smoke');
        Yii::t('app', 'Light Volcanic Ash');
        Yii::t('app', 'Light Widespread Dust');
        Yii::t('app', 'Light Sand');
        Yii::t('app', 'Light Haze');
        Yii::t('app', 'Light Spray');
        Yii::t('app', 'Light Dust Whirls');
        Yii::t('app', 'Light Sandstorm');
        Yii::t('app', 'Light Low Drifting Widespread Dust');
        Yii::t('app', 'Light Low Drifting Sand');
        Yii::t('app', 'Light Blowing Snow');
        Yii::t('app', 'Light Blowing Widespread Dust');
        Yii::t('app', 'Light Blowing Sand');
        Yii::t('app', 'Light Low Drifting Snow');
        Yii::t('app', 'Light Rain Mist');
        Yii::t('app', 'Light Rain Showers');
        Yii::t('app', 'Light Snow Showers');
        Yii::t('app', 'Light Snow Blowing Snow Mist');
        Yii::t('app', 'Light Ice Pellet Showers');
        Yii::t('app', 'Light Hail Showers');
        Yii::t('app', 'Light Small Hail Showers');
        Yii::t('app', 'Light Thunderstorm');
        Yii::t('app', 'Light Thunderstorms and Rain');
        Yii::t('app', 'Light Thunderstorms and Snow');
        Yii::t('app', 'Light Thunderstorms and Ice Pellets');
        Yii::t('app', 'Light Thunderstorms with Hail');
        Yii::t('app', 'Light Thunderstorms with Small Hail');
        Yii::t('app', 'Light Freezing Drizzle');
        Yii::t('app', 'Light Freezing Rain');
        Yii::t('app', 'Light Freezing Fog');
        Yii::t('app', 'Heavy Drizzle');
        Yii::t('app', 'Heavy Rain');
        Yii::t('app', 'Heavy Snow');
        Yii::t('app', 'Heavy Snow Grains');
        Yii::t('app', 'Heavy Ice Crystals');
        Yii::t('app', 'Heavy Ice Pellets');
        Yii::t('app', 'Heavy Hail');
        Yii::t('app', 'Heavy Mist');
        Yii::t('app', 'Heavy Fog');
        Yii::t('app', 'Heavy Fog Patches');
        Yii::t('app', 'Heavy Smoke');
        Yii::t('app', 'Heavy Volcanic Ash');
        Yii::t('app', 'Heavy Widespread Dust');
        Yii::t('app', 'Heavy Sand');
        Yii::t('app', 'Heavy Haze');
        Yii::t('app', 'Heavy Spray');
        Yii::t('app', 'Heavy Dust Whirls');
        Yii::t('app', 'Heavy Sandstorm');
        Yii::t('app', 'Heavy Low Drifting Snow');
        Yii::t('app', 'Heavy Low Drifting Widespread Dust');
        Yii::t('app', 'Heavy Low Drifting Sand');
        Yii::t('app', 'Heavy Blowing Snow');
        Yii::t('app', 'Heavy Blowing Widespread Dust');
        Yii::t('app', 'Heavy Blowing Sand');
        Yii::t('app', 'Heavy Rain Mist');
        Yii::t('app', 'Heavy Rain Showers');
        Yii::t('app', 'Heavy Snow Showers');
        Yii::t('app', 'Heavy Snow Blowing Snow Mist');
        Yii::t('app', 'Heavy Ice Pellet Showers');
        Yii::t('app', 'Heavy Hail Showers');
        Yii::t('app', 'Heavy Small Hail Showers');
        Yii::t('app', 'Heavy Thunderstorm');
        Yii::t('app', 'Heavy Thunderstorms and Rain');
        Yii::t('app', 'Heavy Thunderstorms and Snow');
        Yii::t('app', 'Heavy Thunderstorms and Ice Pellets');
        Yii::t('app', 'Heavy Thunderstorms with Hail');
        Yii::t('app', 'Heavy Thunderstorms with Small Hail');
        Yii::t('app', 'Heavy Freezing Drizzle');
        Yii::t('app', 'Heavy Freezing Rain');
        Yii::t('app', 'Heavy Freezing Fog');
        Yii::t('app', 'Patches of Fog');
        Yii::t('app', 'Shallow Fog');
        Yii::t('app', 'Partial Fog');
        Yii::t('app', 'Overcast');
        Yii::t('app', 'Clear');
        Yii::t('app', 'Partly Cloudy');
        Yii::t('app', 'Mostly Cloudy');
        Yii::t('app', 'Scattered Clouds');
        Yii::t('app', 'Small Hail');
        Yii::t('app', 'Squalls');
        Yii::t('app', 'Funnel Cloud');
        Yii::t('app', 'Unknown Precipitation');
        Yii::t('app', 'Unknown');
        Yii::t('app', 'Clear');
        Yii::t('app', 'Rain');
        Yii::t('app', 'Clouds');
        Yii::t('app', 'Chance of Flurries');
        Yii::t('app', 'Chance of Rain');
        Yii::t('app', 'Chance Rain');
        Yii::t('app', 'Chance of Freezing Rain');
        Yii::t('app', 'Chance of Sleet');
        Yii::t('app', 'Chance of Snow');
        Yii::t('app', 'Chance of Thunderstorms');
        Yii::t('app', 'Chance of a Thunderstorm');
        Yii::t('app', 'Cloudy');
        Yii::t('app', 'Flurries');
        Yii::t('app', 'Fog');
        Yii::t('app', 'Haze');
        Yii::t('app', 'Mostly Sunny');
        Yii::t('app', 'Partly Sunny');
        Yii::t('app', 'Freezing Rain');
        Yii::t('app', 'Sleet');
        Yii::t('app', 'Snow');
        Yii::t('app', 'Sunny');
        Yii::t('app', 'Thunderstorms');
        Yii::t('app', 'Thunderstorm');

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
                    'date_forecast' => $data->FCTTIME->year.'-'.$data->FCTTIME->mon_padded.'-'.$data->FCTTIME->mday,
                    'partofday' => $data->FCTTIME->hour,
                    'temp' => $data->temp->metric,
                    'wind_speed' => ceil($data->wspd->metric * 0.27),
                    'wind_deg' => $degs[ceil($data->wdir->degrees / 22.5)],
                    'humidity' => $data->humidity,
                    'pressure' => ceil($data->mslp->metric * 0.75),
                    'precipitation_id' => $data->wx,
                ];
            }
        }

        Yii::t('app', 'name');
        Yii::t('app', 'date_forecast');
        Yii::t('app', 'partofday');
        Yii::t('app', 'temp');
        Yii::t('app', 'wind_speed');
        Yii::t('app', 'wind_deg');
        Yii::t('app', 'humidity');
        Yii::t('app', 'pressure');
        Yii::t('app', 'precipitation_id');

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



