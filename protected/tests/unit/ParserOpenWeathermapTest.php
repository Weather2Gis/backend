<?php
/**
 * Created by PhpStorm.
 * User: man
 */


class ParserOpenWeatherTest extends CDbTestCase
{



    public function providerCity()
    {
        return [
            ['Novosibirsk'],
            ['Moscow'],
            ['Kemerovo'],
        ];
    }

    /**
     * Тестируем типы
     * @dataProvider providerCity
     */
    public function testType($name)
    {
//        Parser_OpenWeathermap::$response= '{}';
        $ya = Parser_OpenWeathermap::parse($name);

        $data = $ya[1];

        $this->assertInternalType('string', $data['date_forecast']);
        $this->assertInternalType('int', $data['partofday']);
        $this->assertInternalType('int', $data['temp']);
        $this->assertInternalType('float', $data['wind_speed']);
        $this->assertInternalType('int', $data['humidity']);
        $this->assertInternalType('int', $data['pressure']);
        $this->assertInternalType('int', $data['wind_deg']);
        $this->assertInternalType('string', $data['precipitation']);
    }

    /**
     * @dataProvider providerCity
     */
    public function testCountData($name)
    {
//        Parser_OpenWeathermap::$response= '{}';
        $data = Parser_OpenWeathermap::parse($name);

        foreach ($data as $value) {

            $this->assertEquals(count($value), 8);
        }
    }
/*
    public function testValidData()
    {
        Parser_OpenWeathermap::$url = 'http://api.openweathermap.org/data/2.5/forecast?q=%%name%%&units=metric';
//        Parser_OpenWeathermap::$response= '{}';
        $data = Parser_OpenWeathermap::parse('Nytva');
        $data = $data[1];

        $this->assertInternalType('string', $data['date_forecast']);
        $this->assertEquals($data['date_forecast'], '2014-08-21');

        $this->assertInternalType('int', $data['partofday']);
        $this->assertEquals($data['partofday'], 2);

        $this->assertInternalType('int', $data['temp']);
        $this->assertEquals($data['temp'], 22);

        $this->assertInternalType('float', $data['wind_speed']);
        $this->assertEquals($data['wind_speed'], 2.51);

        $this->assertInternalType('int', $data['humidity']);
        $this->assertEquals($data['humidity'], 68);

        $this->assertInternalType('int', $data['pressure']);
        $this->assertEquals($data['pressure'], 756);

        $this->assertInternalType('int', $data['wind_deg']);
        $this->assertEquals($data['wind_deg'], 2);

        $this->assertInternalType('string', $data['precipitation']);
        $this->assertEquals($data['precipitation'], 'Ясно');
    }
*/
}
