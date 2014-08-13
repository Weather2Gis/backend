<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 13.08.2014
 * Time: 13:13
 */

class FillDBController extends Controller
{
    public function actionIndex(){
        $yandex = Parser_Yandex::parse();
        $weather = new Weather();
        $city = new City();

        foreach($yandex as $city){
            $city_id = City::model()->findAllByAttributes(array('name_ru'=>$city['name']))->id;
            $station_id = City::model()->findAllByAttributes(array('city_id'=>$city_id));
            $weather->temp=$city['temp'];
            $weather->humidity=$city['humidity'];
            $weather->pressure=$city['pressure'];
            $weather->wind_speed=$city['speed'];
            $weather->wind_deg=$city['deg'];
            $weather->precipitation_id=$city['weather'];
            $weather->station_id=$station_id;

        }
    }
}