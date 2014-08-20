<?php
/**
 * Created by PhpStorm.
 * User: man

 */

class ParserYandexTest extends CDbTestCase{

    public function testName(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertEquals('Новосибирск',$ya['0']['name']);
    }

    public function testTypeValueData(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('string', $ya['0']['date_forecast']);
    }

    public function testTypeValuePartofday(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('int', $ya['0']['partofday']);
    }

    public function testTypeValueTemp(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('int', $ya['0']['temp']);
    }

    public function testTypeValueSpeed(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('float', $ya['0']['wind_speed']);
    }


    public function testTypeValueHumidity(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('int', $ya['0']['humidity']);
    }

    public function testTypeValuePressure(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('int', $ya['0']['pressure']);
    }

    public function testTypeValueDeg(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('int', $ya['0']['wind_deg']);
    }

    public function testTypeValuePrecipitation(){
        $ya = Parser_Yandex::parse(29634);
        $this->assertInternalType('string', $ya['0']['precipitation']);
    }

}