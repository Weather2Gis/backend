<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 13.08.2014
 * Time: 17:27
 */



class Parser_OpenWeathermap {

    /**
     * Собирает данные с API OpenWeatherMap
     * @param $city город для которого собираются данные
     * @return array|null массив с данными о погоде
     */
    public static function parse($city)
    {
        //list : утро, день, вечер, ночь
        $list = ["09:00:00" => 1, "15:00:00" => 2, "21:00:00" => 3, "03:00:00" => 4];

        $map_weather = [
            'Clear' => "Ясно",
            'Clouds' => "Облачно",
            'Rain' => "Дождь"];

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

		$url = "http://api.openweathermap.org/data/2.5/forecast?q=" . $city->name_en . "&units=metric";
		$json = self::getWeatherForCity($url);
        if(!empty($json)){
            if(!empty($json['list'])){
                foreach($json['list'] as $time){
                    $date = explode(" ", $time['dt_txt'])[0];
                    $partofday = explode(" ", $time['dt_txt'])[1];
                    if(array_key_exists($partofday, $list)){
                        $array[] = [
                            'date_forecast' => (string)$date,
                            'partofday'     => (int)$list[$partofday],
                            'temp'          => (int)ceil($time['main']['temp']),
                            'wind_speed'    => (float)$time['wind']['speed'],
                            'wind_deg'      => (int)$degs[ceil($time['wind']['deg'] / 22.5)],
                            'humidity'      => (int)$time['main']['humidity'],
                            'pressure'      => (int)ceil($time['main']['pressure'] * 0.75),
                            'precipitation' => (string)strtr($time['weather']['0']['main'] , $map_weather)
                        ];
                    }
                }
            }else{
                return null;
            }
        }else{
            return null;
        }
        return $array;
    }

    /**
     * Собирает данные с сайта
     * @param $url адрес сайта
     * @return mixed|null массив с данными
     */
    private static function getWeatherForCity($url){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);

        if(curl_errno($ch)) {
            echo 'Ошибка curl: ' . curl_error($ch);
            exit;
        }

        curl_close($ch);

        $json = json_decode($result, true);

        if (empty($json))
            return null;

        return $json;
    }
}



