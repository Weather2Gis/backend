<?php
/**
 * Created by PhpStorm.
 * User: man
 */

class ParserYandexTest extends CDbTestCase
{

    public function providerCity()
    {
        return [
            [29634],
            [27612],
            [28698],
        ];
    }

    /**
     * Тестируем типы
     * @dataProvider providerCity
     */
    public function testType($id)
    {
        Parser_Yandex::$url = 'unit/testData/yandex/';
        $ya = Parser_Yandex::parse($id);

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
        Parser_Yandex::$url = 'unit/testData/yandex/';
        $data = Parser_Yandex::parse($id);


        $this->assertEquals(count($data), 40);

        // скидываем первый день
        next($data);

        foreach ($data as $value) {

            $this->assertEquals(count($value), 9);
        }
    }

    public function testValidData()
    {
        Parser_Yandex::$url = 'unit/testData/yandex/';
        $data = Parser_Yandex::parse(29634);

        $data = reset($data);

        $this->assertEquals('Новосибирск', $data['name']);

        $this->assertInternalType('string', $data['date_forecast']);
        $this->assertEquals($data['date_forecast'], '2014-08-21');

        $this->assertInternalType('int', $data['partofday']);
        $this->assertEquals($data['partofday'], 1);

        $this->assertInternalType('int', $data['temp']);
        $this->assertEquals($data['temp'], 11);

        $this->assertInternalType('float', $data['wind_speed']);
        $this->assertEquals($data['wind_speed'], 2.3);

        $this->assertInternalType('int', $data['humidity']);
        $this->assertEquals($data['humidity'], 72);

        $this->assertInternalType('int', $data['pressure']);
        $this->assertEquals($data['pressure'], 755);

        $this->assertInternalType('int', $data['wind_deg']);
        $this->assertEquals($data['wind_deg'], 1);

        $this->assertInternalType('string', $data['precipitation']);
        $this->assertEquals($data['precipitation'], 'переменная облачность');
    }


}