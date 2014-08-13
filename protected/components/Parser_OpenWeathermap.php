<?php

class ValueObject
{
    protected $name;        //наименование города
    protected $temp;        //температура
    protected $speed;       //скорость ветра
    protected $humidity;    //влажность
    protected $pressure;   //давление
    protected $deg;         //направление ветра
    protected $weather;     //состояние

    public function __construct(array $data)
    {
        $this->name      = $data['name'];
        $this->temp      = $data['temp'];
        $this->speed     = $data['speed'];
        $this->humidity  = $data['humidity'];
        $this->pressure  = $data['pressure'];
        $this->deg       = $data['deg'];
        $this->weather   = $data['weather'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function getHumidity()
    {
        return $this->humidity;
    }

    public function getPressure()
    {
        return $this->pressure;
    }

    public function getDeg()
    {
        return $this->deg;
    }

    public function getWeather()
    {
        return $this->weather;
    }
}



class Parser_OpenWeathermap
{

    public function parse()
    {

        //$url = api.resourse.param;
        $url = "api.openweathermap.org/data/2.5/box/city?bbox=16,75,179,40,1000&cluster=no";

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
        //print_r($json);
        $map_weather =[
            'Clear'  =>3,
            'Clouds' =>1,
            'Rain'   =>2];

        $degs = [
            0  => 1, 15  => 1, 16 => 1,
            1  => 2, 2   => 2,
            3  => 3, 4   => 3,
            5  => 4, 6   => 4,
            7  => 5, 8   => 5,
            9  => 6, 10  => 6,
            11 => 7, 12  => 7,
            13 => 8, 14  => 8
        ];

        foreach ($json['list'] as $city) {
            $array[$city['id']] = [
                'name' => $city['name'],
                'temp' => $city['main']['temp'],
                'speed' => $city['wind']['speed'],
                'humidity' => $city['main']['humidity'],
                'pressure' => $city['main']['pressure'],
                'deg' => $city['wind']['deg'],
                'weather' => $city['weather']['0']['main']
            ];

            $array[$city['id']]['weather'] = strtr($array[$city['id']]['weather'] , $map_weather).'  ';
            $array[$city['id']]['pressure']= ceil($array[$city['id']]['pressure'] * 0.75);
            $array[$city['id']]['temp']= ceil($array[$city['id']]['temp']);

            $index = ceil($city['wind']['deg'] / 22.5);
            $array[$city['id']]['deg'] = $degs[$index];

        }

        return $array;
    }
}