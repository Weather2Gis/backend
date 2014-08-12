<?php
/**
 * Created by PhpStorm.
 * User: man
 * Date: 12.08.2014
 * Time: 11:52
 */

include "1.php";
$qwe = new weather();

$data = $qwe->getData('weather');

foreach ($data as $value) {
echo $value['name'] . ' ' . $value['temp'] . ' ' . $value['speed'] . ' ' .
     $value['coord_lon']  . ' ' . $value['coord_lat'] . ' ' . $value['humidity'] . ' ' .
     $value['pressure'] . ' ' . $value['deg'] . ' ' . $value['weather'];

} 