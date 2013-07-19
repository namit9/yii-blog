<?php
/* @var $this UserController */
/* @var $data User */
?>

<div class="view">

	<b><?php //echo CHtml::encode($data->getAttributeLabel('id')); ?></b>
	<?php //echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>

	<b><?php //echo CHtml::encode($data->getAttributeLabel('username')); ?></b>
<div class="username">	
	<?php echo CHtml::link(CHtml::encode($data->username),array('view','id'=>$data->id)); ?>
	<br />
</div>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('password')); ?></b>
	<?php //echo CHtml::encode($data->password); ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('profile')); ?></b>
	<?php echo CHtml::encode($data->profile); ?>
	<br />


</div>
