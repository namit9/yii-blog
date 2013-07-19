<?php
/* @var $this PostController */
/* @var $data Post */
?>

<div class="view">

<?php /*	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />*/?>

	<b><?php //echo CHtml::encode($data->getAttributeLabel('title')); ?></b>
	<?php echo CHtml::link(CHtml::encode($data->title),array('post/view','id'=>$data->id,'title'=>$data->title),array('id'=>'post-title')); ?>
	<br />
	<?php echo "posted by ".CHtml::link($data->author->username,array('user/view','id'=>$data->author_id))." on ".date('F j, Y',$data->create_time);
	?>
	<br/>
	<br/>

	<b><?php //echo CHtml::encode($data->getAttributeLabel('content')); ?></b>
	<?php echo CHtml::encode($data->content); ?>
	<br />
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
	<?php 
	$tags=explode(", ",$data->tags);
	foreach($tags as $posttag)
		echo CHtml::link(CHtml::encode($posttag),array('post/index','tag'=>$posttag)).' ';
	 ?>
	<br />
	<br />
	<?php echo CHtml::link('Permalink',$data->url).' | '; ?>
	<?php echo CHtml::link('Comments('.$data->commentCount.')',$data->url.'#comments').' | '; ?>
	<?php echo "Last updated on ".date('F j, Y',$data->update_time); ?>
		

<?php /*	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('author_id')); ?>:</b>
	<?php echo CHtml::encode($data->author_id); ?>
	<br />

	*/ ?>

</div>
