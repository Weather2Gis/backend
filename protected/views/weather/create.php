<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->breadcrumbs=array(
	'Weathers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Weather', 'url'=>array('index')),
	array('label'=>'Manage Weather', 'url'=>array('admin')),
);
?>

<h1>Create Weather</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>