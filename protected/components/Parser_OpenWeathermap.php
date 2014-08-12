<?php

class ValueObject
{
    protected $name;        //наименование города
    protected $temp;        //температура
    protected $speed;       //скорость ветра
    protected $coord_lon;   //координаты долготы
    protected $coord_lat;   //координаты широты
    protected $humidity;    //влажность
    protected $pressure;   //давление
    protected $deg;         //направление ветра
    protected $weather;     //состояние

    public function __construct(array $data)
    {
        $this->name      = $data['name'];
        $this->temp      = $data['temp'];
        $this->speed     = $data['speed'];
        $this->coord_lon = $data['coord_lon'];
        $this->coord_lat = $data['coord_lat'];
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

    public function getCoordLon()
    {
        return $this->coord_lon;
    }

    public function getCoordLat()
    {
        return $this->coord_lat;
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

        foreach ($json['list'] as $city) {
            $array[$city['id']] = [
                'name' => $city['name'],
                'temp' => $city['main']['temp'],
                'speed' => $city['wind']['speed'],
                'coord_lon' => $city['coord']['lon'],
                'coord_lat' => $city['coord']['lat'],
                'humidity' => $city['main']['humidity'],
                'pressure' => $city['main']['pressure'],
                'deg' => $city['wind']['deg'],
                'weather' => $city['weather']['0']['main']
            ];

                        if ($city['wind']['deg'] <= 22.5 || $city['wind']['deg'] > 337.5) {
                            $array[$city['id']]['deg'] = 'северный';
                        }
                        if ($city['wind']['deg'] <= 67.5 && $city['wind']['deg'] > 22.5) {
                            $array[$city['id']]['deg'] = 'северо-восточныйный';
                        }
                        if ($city['wind']['deg'] <= 112.5 && $city['wind']['deg'] > 67.5) {
                            $array[$city['id']]['deg'] = 'восточный';
                        }
                        if ($city['wind']['deg'] <= 157.5 && $city['wind']['deg'] > 112.5) {
                            $array[$city['id']]['deg'] = 'юго-восточный';
                        }
                        if ($city['wind']['deg'] <= 202.5 && $city['wind']['deg'] > 157.5) {
                            $array[$city['id']]['deg'] = 'южный';
                        }
                        if ($city['wind']['deg'] <= 247.5 && $city['wind']['deg'] > 202.5) {
                            $array[$city['id']]['deg'] = 'юго-западный';
                        }
                        if ($city['wind']['deg'] <= 292.5 && $city['wind']['deg'] > 247.5) {
                            $array[$city['id']]['deg'] = 'западный';
                        }
                        if ($city['wind']['deg'] <= 337.5 && $city['wind']['deg'] > 292.5) {
                            $array[$city['id']]['deg'] = 'северо-западный';
                        }

                        switch ($city['weather']['0']['main']) {
                            case 'Clear':
                                $array[$city['id']]['weather'] = 'Ясно';
                                break;
                            case 'Clouds':
                                $array[$city['id']]['weather'] = 'Облачно';
                                break;
                            case 'Rain':
                                $array[$city['id']]['weather'] = 'Дождь';
                                break;
                        }

        }
        return $array;


    }
}