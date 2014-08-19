<?php
/* @var $this WeatherController */

$this->menu=array(
    array('label'=>'Управление базой данных погоды', 'url'=>array('admin'))
);
?>

<h2>Пример запросов на один день</h2>
    <p>Поиск по городу: <pre>/?r=weather/find&city=Novosibirsk&pr=ya</pre></p>
    <p>Поиск по координатам: <pre>/?r=weather/find&lat=55.753676&lon=37.619899&pr=owm</pre></p>
    <p>Поиск в пределах прямоугольника: <pre>/?r=weather/find&lon_top=82.560544&lat_top=55.174534&lon_bottom=83.318972&lat_bottom=54.843024</pre></p>

    <h2>Пример запросов на несколько дней вперед с временем суток</h2>
    <p>Поиск по городу: <pre>/?r=weather/forecast&city=Novosibirsk&pr=ya</pre></p>
    <p>Поиск по координатам: <pre>/?r=weather/forecast&lat=55.753676&lon=37.619899&pr=owm</pre></p>
