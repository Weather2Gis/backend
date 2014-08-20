<?php
/**
 * Created by PhpStorm.
 * User: man
 */

/*
class ParserOpenWeatherTest extends CDbTestCase
{

    protected $city;

    protected function setUp(){
        parent::setUp();
        $this->city = new City();
    }

    public function testTypeValueData()
    {
        $this->city->name_en = 'Omsk';
        $ya = Parser_OpenWeathermap::parse($this->city);
        $this->assertInternalType('string', $ya['date_forecast']);
    }

//    public function testTypeValuePartofday()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city);
//        $this->assertInternalType('int', $ya['0']['partofday']);
//    }
//
//    public function testTypeValueTemp()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city);
//        $this->assertInternalType('int', $ya['0']['temp']);
//    }
//
//    public function testTypeValueSpeed()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city->name_en);
//        $this->assertInternalType('float', $ya['0']['wind_speed']);
//    }
//
//    public function testTypeValueHumidity()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city);
//        $this->assertInternalType('int', $ya['0']['humidity']);
//    }
//
//    public function testTypeValuePressure()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city);
//        $this->assertInternalType('int', $ya['0']['pressure']);
//    }
//
//    public function testTypeValueDeg()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city);
//        $this->assertInternalType('int', $ya['0']['wind_deg']);
//    }
//
//    public function testTypeValuePrecipitation()
//    {
//        $ya = Parser_OpenWeathermap::parse($this->city);
//        $this->assertInternalType('string', $ya['0']['precipitation']);
//    }

}