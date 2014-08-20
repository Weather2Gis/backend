<?php
/**
 * Created by PhpStorm.
 * User: man
 */



//эти тесты сегодя не работают ограничение количества обращений к апи (
/*
class WUParserTest extends CDbTestCase
{

    public function testTypeValueData()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('string', $wu['0']['date_forecast']);
    }

    public function testTypeValuePartofday()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('int', $wu['0']['partofday']);
    }

    public function testTypeValueTemp()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('int', $wu['0']['temp']);
    }

    public function testTypeValueSpeed()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('float', $wu['0']['wind_speed']);
    }


    public function testTypeValueHumidity()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('int', $wu['0']['humidity']);
    }

    public function testTypeValuePressure()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('int', $wu['0']['pressure']);
    }

    public function testTypeValueDeg()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('int', $wu['0']['wind_deg']);
    }

    public function testTypeValuePrecipitation()
    {
        $wu = WUParser::parse('Москва');
        $this->assertInternalType('string', $wu['0']['precipitation']);
    }
}