<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<?php Yii::app()->clientScript->registerScript('changePassword', "
$('.changePassword').click(function(){
        $('.update').toggle();
        return false;
});
");
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile'); ?>
		<?php echo $form->textArea($model,'profile',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'profile'); ?>
	</div>

	<div class="row">
                <?php echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
                <?php echo $form->error($model,'password'); ?>
        </div>
        
	<?php if($_GET["r"]=='user/update'): ?>
	
	<div class="row update" style="display:none">
                <?php echo $form->labelEx($model,'newPassword'); ?>
                <?php echo $form->passwordField($model,'newPassword',array('size'=>60,'maxlength'=>128)); ?>
                <?php echo $form->error($model,'newPassword'); ?>
        </div>

        <div class="row update" style="display:none">
                <?php echo $form->labelEx($model,'confirmNewPassword'); ?>
                <?php echo $form->passwordField($model,'confirmNewPassword',array('size'=>60,'maxlength'=>128)); ?>
                <?php echo $form->error($model,'confirmNewPassword'); ?>
        </div>  
             
	<?php echo CHtml::link('Change Password','#',array('class'=>'changePassword')); ?>
	
	<?php endif; ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
