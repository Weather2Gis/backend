<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->menu=array(
	array('label'=>'Новые данные о погоде', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#weather-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление погодными данными</h1>

<p>Можно ввести оператор сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) в начале каждого столбца, чтобы определить, какое сравнение должно быть сделано.
</p>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'weather-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'date_forecast',
		'temp',
		'humidity',
		'pressure',
		'wind_speed',
		/*
		'wind_deg',
		'precipitation_id',
		'station_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
