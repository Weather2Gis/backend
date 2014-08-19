<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 19.08.2014
 * Time: 14:28
 */

class ParserYandexTest extends PHPUnit_Framework_TestCase{

    public function testSaveToDb(){

        $ya = Parser_Yandex::parse(29634);

        $this->assertEquals(true, isset($ya['name']));

//        $city = City::model()->findByAttributes(array('name_ru' => $ya['name']));
//        $cityNameTest = 'Novosibirsk';
//
//        $this->assertEquals($city, $cityNameTest);
//        $this->assertEquals(1, 2);
//        $this->assertEquals(1, 3, "TEST");
    }





    # получение погоды
    # запись в базу
    # выдача
        # по городу
        # по квадрату
        # ...
    # кэширование




}