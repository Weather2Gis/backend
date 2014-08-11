<?php
/* @var $this WeatherController */
/* @var $data Weather */
?>

<div class="view">

	<h2><?php echo CHtml::link(CHtml::encode($data->station->city->name_ru), array('view', 'id'=>$data->id)); ?></h2>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_forecast')); ?>:</b>
	<?php echo CHtml::encode($data->date_forecast); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp')); ?>:</b>
	<?php echo CHtml::encode($data->temp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('humidity')); ?>:</b>
	<?php echo CHtml::encode($data->humidity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pressure')); ?>:</b>
	<?php echo CHtml::encode($data->pressure); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wind_speed')); ?>:</b>
	<?php echo CHtml::encode($data->wind_speed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('wind_deg')); ?>:</b>
	<?php echo CHtml::encode($data->wind_deg); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('precipitation_id')); ?>:</b>
	<?php echo CHtml::encode($data->precipitation_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('station_id')); ?>:</b>
	<?php echo CHtml::encode($data->station_id); ?>
	<br />

	*/ ?>

</div>