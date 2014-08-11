<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->breadcrumbs=array(
	'Weathers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Weather', 'url'=>array('index')),
	array('label'=>'Create Weather', 'url'=>array('create')),
	array('label'=>'Update Weather', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Weather', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Weather', 'url'=>array('admin')),
);
?>

<h1>View Weather #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date_forecast',
		'temp',
		'humidity',
		'pressure',
		'wind_speed',
		'wind_deg',
		'precipitation_id',
		'station_id',
	),
)); ?>
