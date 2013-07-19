<?php
/* @var $this CommentController */
/* @var $data Comment */
?>
<div class="view">
	
	<?php //if($data->post->author_id==Yii::app()->user->id) ?>
	<?php echo $data->authorLink.' says on '.CHtml::link(CHtml::encode($data->post->title),$data->post->url).' :'; ?>
	<br>
	<?php if($data->status==Comment::STATUS_PENDING): ?>
	<?php echo "Pending approval | "; ?> 
	<?php echo CHtml::linkButton('Approve',array(
				'submit'=>array('comment/approve','id'=>$data->id),
	)).' | '; ?>
	<?php endif; ?>	
	<?php //echo CHtml::link('Update',array('comment/update','id'=>$data->id)); ?>
	<?php  echo CHtml::link("Delete", '#', array('confirm' => 'Are you sure?', 'submit'=>array('delete','id'=>$data->id))); ?>
	<?php echo ' | '.date('F j, Y',$data->create_time); ?>
	<br>
	<br>
	<?php echo nl2br(CHtml::encode($data->content)); ?>
	<br />
	<?php //endif; ?>
	
	<?php /*//echo CHtml::encode($data->getAttributeLabel('status')); ?></b>
	<?php //echo CHtml::encode($data->status); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('create_time')); ?></b>
	<?php //echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('author')); ?></b>
	<?php //echo CHtml::encode($data->author); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('email')); ?></b>
	<?php //echo CHtml::encode($data->email); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('url')); ?></b>
	<?php //echo CHtml::encode($data->url); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('post_id')); ?>:</b>
	<?php echo CHtml::encode($data->post_id); ?>
	<br />

	*/ ?>

</div>
