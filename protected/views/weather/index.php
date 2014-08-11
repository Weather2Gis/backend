<?php
/* @var $this WeatherController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Weathers',
);

$this->menu=array(
	array('label'=>'Create Weather', 'url'=>array('create')),
	array('label'=>'Manage Weather', 'url'=>array('admin')),
);
?>

<h1>Weathers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
