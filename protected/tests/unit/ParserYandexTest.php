<?php
/**
 * Created by PhpStorm.
 * User: man
 */

class ParserYandexTest extends CDbTestCase
{

    protected function setUpBeforeClass()
    {
        // /test/units/testData/yandex/29634.xml
        // /test/units/testData/yandex/27612.xml
        // /test/units/testData/yandex/28698.xml
        Parse_Yandex::$url = '/test/units/testData/yandex/';
    }

    public function providerCity()
    {
        return [
            ['Новосибирск', 29634],
            ['Омск', 27612],
            ['Москва', 28698],
        ];
    }

    /**
     * Тестируем типы
     * @dataProvider providerCity
     */
    public function testType($name, $id)
    {
        $ya = Parser_Yandex::parse($id);

        $data = $ya[0];

        $this->assertEquals($name, $data['name']);
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
    public function testCountData($name, $id)
    {
        $data = Parse_Yandex::parse($id);

        // проверяем на сколько дней прогноз
        $this->assertEquals(count($data), 10);

        // скидываем первый день
        next($data);

        foreach ($data as $value) {
            // проверяем что в каждом дне 4 прогноза
            $this->assertEquals(count($value), 4);
        }
    }

    public function testValidData()
    {
        Parse_Yandex::$url = '/test/units/testData/yandex/validaData/';
        $data = Parse_Yandex::parse(29634);

        $data = reset($data);

        $this->assertEquals('Новосибирск', $data['name']);

        $this->assertInternalType('string', $data['date_forecast']);
        $this->assertEquals($data['date_forecast'], '2014-08-20');

        $this->assertInternalType('int', $data['partofday']);
        $this->assertEquals($data['partofday'], 2);

        $this->assertInternalType('int', $data['temp']);
        $this->assertEquals($data['temp'], 23);

        $this->assertInternalType('float', $data['wind_speed']);
        $this->assertEquals($data['wind_speed'], 3);

        $this->assertInternalType('int', $data['humidity']);
//        $this->assertEquals($data['humidity']);

        $this->assertInternalType('int', $data['pressure']);
        $this->assertEquals($data['pressure'], 234);

        $this->assertInternalType('int', $data['wind_deg']);
        $this->assertEquals($data['wind_deg'], 1);

        $this->assertInternalType('string', $data['precipitation']);
        $this->assertEquals($data['precipitation'], 'qwe');
    }

    public function testFileNotFound()
    {
        Parse_Yandex::$url = '/test/units/testData/yandex/';
        $data = Parse_Yandex::parse(123123);        

        $this->assertEquals($data, false);

        $errors = Parse_Yandex::$errors;

        $this->assertEquals($errors, '');
    }
}