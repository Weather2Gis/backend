<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->menu=array(
    array('label'=>'Управление погодными данными', 'url'=>array('admin')),
	array('label'=>'Создать погодные данные', 'url'=>array('create')),
	array('label'=>'Обновить погодные данные', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить погодные данные', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить данные?')),
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
