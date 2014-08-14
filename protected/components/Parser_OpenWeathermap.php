<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 13.08.2014
 * Time: 17:27
 */

class Parser_OpenWeathermap {
    public static function parse($city)
    {
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

		$url = "http://api.openweathermap.org/data/2.5/forecast?q=" . $city->name_en;
		$json = Parser_OpenWeathermap::getWeatherForCity($url);
		if (isset($json['list'])){
			foreach ($json['list'] as $weather) {
				$date = explode(" ", $weather['dt_txt'])[0];
				$array[$date] = [
					'name' => $json['city']['name'],
					'temp' => $weather['main']['temp'],
					'speed' => $weather['wind']['speed'],
					'humidity' => $weather['main']['humidity'],
					'pressure' => $weather['main']['pressure'],
					'deg' => $weather['wind']['deg'],
					'weather' => $weather['weather']['0']['main']
				];

				$array[$date]['weather'] = strtr($array[$date]['weather'] , $map_weather).'  ';
				$array[$date]['pressure']= ceil($array[$date]['pressure'] * 0.75);
				$array[$date]['temp']= ceil($array[$date]['temp']);

				$index = ceil($weather['wind']['deg'] / 22.5);
				$array[$date]['deg'] = $degs[$index];
			}
		}
			
        return $array;
    }

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

        if (empty($json['list']))
            return null;

        return $json;
    }
} 