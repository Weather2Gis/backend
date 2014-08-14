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
        $this->fillOpenWeather();
        //$this->fillYandex();
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

                $weather->save();

            }
        }
    }

    private function fillOpenWeather(){      

		$citys = City::model()->findAll();
        foreach($citys as $city){
			$openWeather = Parser_OpenWeathermap::parse($city);
            if(isset($openWeather)){
                foreach($openWeather as $main){
                    var_dump($city);
                    $weather = new Weather();
                    $station = Weatherstation::model()->findByAttributes(array('city_id'=>$city->id));
                    $weather->date_forecast = $main['date_forecast'];
                    $weather->partofday = $main['partofday'];
                    $weather->temp=$main['temp'];
                    $weather->humidity=$main['humidity'];
                    $weather->pressure=$main['pressure'];
                    $weather->wind_speed=$main['wind_speed'];
                    $weather->wind_deg=$main['wind_deg'];
                    $weather->precipitation_id=$main['precipitation_id'];
                    $weather->station_id=$station->id;
                    $weather->provider_id = 2;
                    $weather->save();
                }
            }

        }
    }
}