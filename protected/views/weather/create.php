<?php
/* @var $this WeatherController */
/* @var $model Weather */


$this->menu=array(
	array('label'=>'Управление погодными данными', 'url'=>array('admin')),
);
?>

<h1>Создать погодные данные</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>