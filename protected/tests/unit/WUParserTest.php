<?php
/**
 * Created by PhpStorm.
 * User: man
 */



class WUParserTest extends CDbTestCase
{

    public function providerCity()
    {
        return [
            ['Москва'],
            ['Новосибирск'],
            ['Nytva'],
        ];
    }

    /**
     * Тестируем типы
     * @dataProvider providerCity
     */
    public function testType($id)
    {
        WUParser::$url = 'http://api.wunderground.com/api/abf440f8782645dc/hourly10day/forecast/lang:RU/q/Россия/';
        $ya = WUParser::parse($id);

        $data = $ya[0];

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
    public function testCountData($id)
    {
        WUParser::$url = 'http://api.wunderground.com/api/abf440f8782645dc/hourly10day/forecast/lang:RU/q/Россия/';
        $data = WUParser::parse($id);


        $this->assertEquals(count($data), 40);

        // скидываем первый день
        next($data);

        foreach ($data as $value) {

            $this->assertEquals(count($value), 8);
        }
    }

    public function testValidData()
    {
        WUParser::$url = 'http://api.wunderground.com/api/abf440f8782645dc/hourly10day/forecast/lang:RU/q/Россия/';
        $data = WUParser::parse('Новосибирск');

        $data = reset($data);

        $this->assertInternalType('string', $data['date_forecast']);
        $this->assertEquals($data['date_forecast'], '2014-08-21');

        $this->assertInternalType('int', $data['partofday']);
        $this->assertEquals($data['partofday'], 2);

        $this->assertInternalType('int', $data['temp']);
        $this->assertEquals($data['temp'], 19);

        $this->assertInternalType('float', $data['wind_speed']);
        $this->assertEquals($data['wind_speed'], 2.3);

        $this->assertInternalType('int', $data['humidity']);
        $this->assertEquals($data['humidity'], 73);

        $this->assertInternalType('int', $data['pressure']);
        $this->assertEquals($data['pressure'], 755);

        $this->assertInternalType('int', $data['wind_deg']);
        $this->assertEquals($data['wind_deg'], 1);

        $this->assertInternalType('string', $data['precipitation']);
        $this->assertEquals($data['precipitation'], 'переменная облачность');
    }



}