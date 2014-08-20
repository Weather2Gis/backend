<?php
/* @var $this WeatherController */
/* @var $model Weather */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_forecast'); ?>
		<?php echo $form->textField($model,'date_forecast'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'temp'); ?>
		<?php echo $form->textField($model,'temp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'humidity'); ?>
		<?php echo $form->textField($model,'humidity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pressure'); ?>
		<?php echo $form->textField($model,'pressure'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wind_speed'); ?>
		<?php echo $form->textField($model,'wind_speed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'wind_deg'); ?>
		<?php echo $form->textField($model,'wind_deg'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'precipitation'); ?>
		<?php echo $form->textField($model,'precipitation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'station_id'); ?>
		<?php echo $form->textField($model,'station_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->