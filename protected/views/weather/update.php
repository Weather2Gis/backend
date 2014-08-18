<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->breadcrumbs=array(
	'Weathers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
    array('label'=>'Управление погодными данными', 'url'=>array('admin')),
	array('label'=>'Создать погодные данные', 'url'=>array('create')),
	array('label'=>'Просмотреть', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Обновление погодных данных <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>