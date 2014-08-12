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
    protected $api = "http://api.openweathermap.org/data/2.5";
    protected $resource = "/box/city";
    protected $params = [
        "bbox" => '18,76,178,36,10000',
        "cluster" => "no"
    ];

    public function parse()
    {
        $result =[];
        $url = api.resourse.param;
/*
        $curl_result =
        '
{
    "list":[
        {
            "coord":{"lon":139,"lat":35},
            "sys":{"country":"JP","sunrise":1369769524,"sunset":1369821049},
            "weather":[{"id":804,"main":"clouds","description":"overcast clouds","icon":"04n"}],
            "main":{"temp":289.5,"humidity":89,"pressure":1013,"temp_min":287.04,"temp_max":292.04},
            "wind":{"speed":7.31,"deg":187.002},
            "rain":{"3h":0},
            "clouds":{"all":92},
            "dt":1369824698,
            "id":1851632,
            "name":"Shuzenji",
            "cod":200
        }
    ]
}';
        $json = json_decode($curl_result, true);

        if (empty($json['list']))
            return null;

        foreach ($json['list'] as $city) {
            $result[$city['id']] = [
                'name' => $city['name'],
                'temp' => $city['main']['temp'],
            ];
        }
       // return $result;
*/
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

        foreach ($json['list'] as $city) {
            $result[$city['id']] = [
                'name'      => $city['name'],
                'temp'      => $city['main']['temp'],
                'speed'     => $city['wind']['speed'],
                'coord_lon' => $city['coord']['lon'],
                'coord_lat' => $city['coord']['lat'],
                'humidity'  => $city['main']['humidity'],
                'pressure'  => $city['main']['pressure'],
                'deg'       => $city['wind']['deg'],
                'weather'   => $city['weather']['main'],
            ];
        }

        return $json;
    }
}