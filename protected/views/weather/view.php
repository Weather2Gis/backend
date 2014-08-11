<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->breadcrumbs=array(
	'Weathers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Список информации по погоде', 'url'=>array('list')),
	array('label'=>'Создать информацию по погоде', 'url'=>array('create')),
	array('label'=>'Обновить информацию по погоде', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить информацию по погоде', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление информацией по погоде', 'url'=>array('admin')),
);
?>

<h1>Погода для <?php echo $model->station->city->name_ru; ?></h1>

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
