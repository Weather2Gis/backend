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
        //$this->fillYandex();
        $this->fillOpenWeather();
    }

    private function fillYandex(){
        $yandex = Parser_Yandex::parse();
        $weather = new Weather();

        foreach($yandex as $city){
            foreach($city as $date=>$main){
                $city_id = City::model()->findAllByAttributes(array('name_ru'=>$main['name']))->id;
                $station_id = City::model()->findAllByAttributes(array('city_id'=>$city_id));
                $weather->date_forecast = $date;
                $weather->temp=$main['temp'];
                $weather->humidity=$main['humidity'];
                $weather->pressure=$main['pressure'];
                $weather->wind_speed=$main['speed'];
                $weather->wind_deg=$main['deg'];
                $weather->precipitation_id=$main['weather'];
                $weather->station_id=$station_id;
                $weather->save(false);
            }
        }
    }

    private function fillOpenWeather(){
        $openWeather = Parser_OpenWeathermap::parse(City::model()->findAll());
        $weather = new Weather();

        foreach($openWeather as $city){
            foreach($city as $date=>$main){
                $city_id = City::model()->findAllByAttributes(array('name_ru'=>$main['name']))->id;
                $station_id = City::model()->findAllByAttributes(array('city_id'=>$city_id));
                $weather->date_forecast = $date;
                $weather->temp=$main['temp'];
                $weather->humidity=$main['humidity'];
                $weather->pressure=$main['pressure'];
                $weather->wind_speed=$main['speed'];
                $weather->wind_deg=$main['deg'];
                $weather->precipitation_id=$main['weather'];
                $weather->station_id=$station_id;
                $weather->save(false);
            }
        }
    }
}