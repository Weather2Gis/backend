<?php
/* @var $this WeatherController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Погода',
);

$this->menu=array(
	array('label'=>'Создать информацию по погоде', 'url'=>array('create')),
	array('label'=>'Управление базой данных погоды', 'url'=>array('admin')),
);
?>

<h1>Погода</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
