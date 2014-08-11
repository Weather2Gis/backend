<?php
/* @var $this WeatherController */
/* @var $model Weather */

$this->breadcrumbs=array(
	'Weathers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Weather', 'url'=>array('index')),
	array('label'=>'Create Weather', 'url'=>array('create')),
	array('label'=>'View Weather', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Weather', 'url'=>array('admin')),
);
?>

<h1>Update Weather <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>