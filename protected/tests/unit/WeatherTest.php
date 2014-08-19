<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 19.08.2014
 * Time: 20:56
 */

class WeatherTest extends CDbTestCase {

    /**
     * @var Weather
     */
    protected $weather;

    protected function setUp()
    {
        parent::setUp();
        $this->weather = new Weather();
    }

    public function testDateIsRequired(){
        $this->weather->date_forecast = '';
        $this->assertFalse($this->weather->validate(array('date_forecast')));
    }

    public function testPartofdayIsRequired(){
        $this->weather->partofday = '';
        $this->assertFalse($this->weather->validate(array('partofday')));
    }

    public function testTempIsRequired(){
        $this->weather->temp = '';
        $this->assertFalse($this->weather->validate(array('temp')));
    }

    public function testHumidityIsRequired(){
        $this->weather->humidity = '';
        $this->assertFalse($this->weather->validate(array('humidity')));
    }

    public function testPressureIsRequired(){
        $this->weather->pressure = '';
        $this->assertFalse($this->weather->validate(array('pressure')));
    }

    public function testWind_speedIsRequired(){
        $this->weather->wind_speed = '';
        $this->assertFalse($this->weather->validate(array('wind_speed')));
    }

    public function testWind_degIsRequired(){
        $this->weather->wind_deg = 'not-exist-value';
        $this->assertFalse($this->weather->validate(array('wind_deg')));
    }

    public function testStationIsRequired(){
        $this->weather->station_id = 'not-exist-value';
        $this->assertFalse($this->weather->validate(array('station_id')));
    }

    public function testProviderIsRequired(){
        $this->weather->provider_id = 'not-exist-value';
        $this->assertFalse($this->weather->validate(array('provider_id')));
    }

    public function testPrecipitationIsRequired(){
        $this->weather->precipitation = '';
        $this->assertFalse($this->weather->validate(array('precipitation')));
    }
} 