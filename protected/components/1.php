<?php

class weather
{
    public function _construct($parser)
    {
        $this->_parser = $this->_getParser($parser);
    }
    /*
    $data = [
        name => [
            temp => '',
            coord => [

            ],
            weather => [

            ]
        ],
        name => [
            ...
        ]
    ];
    */

    public function getData($parser)
    {
        $parser = $this->_getParser($parser);
        $data = $parser->parse();
        return $data;
    }


    protected function _getParser($parser = 'weather')
    {
        switch ($parser) {
            case 'weather':
                include 'Parser_OpenWeathermap1.php';
                $parser = new Parser_OpenWeathermap();
                break;
            
            default:
                die('нет такого парсера');
                break;
        }

        return $parser;
    }
}


$qwe = new weather();

$data = $qwe->getData('weather');

foreach ($data as $value) {
    echo $value['name'].'<br>'.
         $value['temp'] .'<br>'.
         $value['speed'] .'<br>'.
         $value['humidity'] .'<br>'.
         $value['pressure'] .'<br>'.
         $value['deg'] .'<br>'.
         $value['weather'].'<br>';
}
