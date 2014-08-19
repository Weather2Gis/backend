<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 15.08.2014
 * Time: 13:08
 */

class WUParser extends CComponent
{
    public static function parse($cityName)
    {
        //list : утро, день, вечер, ночь
        $list = ["9" => 1, "15" => 2, "21" => 3, "3" => 4];

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

        $url = 'http://api.wunderground.com/api/abf440f8782645dc/hourly10day/forecast/q/Россия/'.$cityName.'.xml';
        $xml = simplexml_load_file($url);

        if(isset($xml->hourly_forecast->forecast->FCTTIME->pretty)) {

            foreach ($xml->hourly_forecast as $hourly_forecast) {
                foreach ($hourly_forecast as $data) {
                    /**
                     * @var $data SimpleXMLElement
                     */

                    if (!isset($list[(string)$data->FCTTIME->hour])) {
                        continue;
                    }

                    $array[] = [
                        'date_forecast' => $data->FCTTIME->year.'-'.$data->FCTTIME->mon_padded.'-'.$data->FCTTIME->mday,
//                        'partofday' => $data->FCTTIME->hour,
                        'temp' => $data->temp->metric,
                        'wind_speed' => ceil($data->wspd->metric * 0.27),
                        'wind_deg' => $degs[ceil($data->wdir->degrees / 22.5)],
                        'humidity' => $data->humidity,
                        'pressure' => ceil($data->mslp->metric * 0.75),
                        'precipitation_id' => Yii::t('app', (string)$data->wx),
                    ];
                }
            }

            foreach ($array as $data) {
                echo 'имя =                 ' . $cityName, '<br>';
                echo 'дата =                ' . $data['date_forecast'], '<br>';
//                echo 'час =                 ' . $data['partofday'], '<br>';
                echo 'температура =         ' . $data['temp'], '<br>';
                echo 'скорость ветра =      ' . $data['wind_speed'], '<br>';
                echo 'направление ветра =   ' . $data['wind_deg'], '<br>';
                echo 'влажность =           ' . $data['humidity'], '<br>';
                echo 'давление =            ' . $data['pressure'], '<br>';
                echo 'состояние =           ' . $data['precipitation_id'], '<br>';
            }
            return $array;
        }
    }
}


