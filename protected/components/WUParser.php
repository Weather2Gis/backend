<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 15.08.2014
 * Time: 13:08
 */



class WUParser extends CComponent
{
    /**Собирает данные с api wundeground
     * @param $cityName имя города для которого собираются данные
     * @return array|null массив с данными о погоде
     */
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

        $url = 'http://api.wunderground.com/api/abf440f8782645dc/hourly10day/forecast/lang:RU/q/Россия/'.$cityName.'.xml';
        $xml = simplexml_load_file($url);

        if(isset($xml->hourly_forecast->forecast->FCTTIME->pretty)) {
            foreach ($xml->hourly_forecast as $hourly_forecast) {
                foreach ($hourly_forecast as $data) {
                    /**
                     * @var $data SimpleXMLElement
                     */

                    if (!isset($list[(string)$data->FCTTIME->hour])) continue;

                    $array[] = [
                        'date_forecast' => (string)$data->FCTTIME->year.'-'.$data->FCTTIME->mon_padded.'-'.$data->FCTTIME->mday,
                        'partofday' => (int)$list[(string)$data->FCTTIME->hour],
                        'temp' => (int)$data->temp->metric,
                        'wind_speed' => (float)ceil($data->wspd->metric * 0.27),
                        'wind_deg' => (int)$degs[ceil($data->wdir->degrees / 22.5)],
                        'humidity' => (int)$data->humidity,
                        'pressure' => (int)ceil($data->mslp->metric * 0.75),
                        'precipitation' => Yii::t('app', (string)$data->wx),
                    ];
                }
            }
            return $array;
        }else{
            return null;
        }
    }
}


