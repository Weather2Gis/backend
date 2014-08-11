<?php
/* @var $this WeatherController */
/* @var $model Weather */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'weather-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date_forecast'); ?>
		<?php echo $form->textField($model,'date_forecast'); ?>
		<?php echo $form->error($model,'date_forecast'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp'); ?>
		<?php echo $form->textField($model,'temp'); ?>
		<?php echo $form->error($model,'temp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'humidity'); ?>
		<?php echo $form->textField($model,'humidity'); ?>
		<?php echo $form->error($model,'humidity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pressure'); ?>
		<?php echo $form->textField($model,'pressure'); ?>
		<?php echo $form->error($model,'pressure'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wind_speed'); ?>
		<?php echo $form->textField($model,'wind_speed'); ?>
		<?php echo $form->error($model,'wind_speed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'wind_deg'); ?>
		<?php echo $form->textField($model,'wind_deg'); ?>
		<?php echo $form->error($model,'wind_deg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'precipitation_id'); ?>
		<?php echo $form->textField($model,'precipitation_id'); ?>
		<?php echo $form->error($model,'precipitation_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'station_id'); ?>
		<?php echo $form->textField($model,'station_id'); ?>
		<?php echo $form->error($model,'station_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->