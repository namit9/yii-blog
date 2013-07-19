<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
//	'Users'=>array('index'),
	$model->username,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_view', array(
        'data'=>$model,
   //    'itemView'=>'_view',
	));
?>

<?php if($model->postCount>=1): ?>

<h3>
<?php echo $model->postCount.' Post(s)'; ?>
</h3>

<?php $this->widget('zii.widgets.CListView',array(
			'dataProvider'=>$posts,
			'itemView'=>'/post/_view',
			'template'=>"{items}\n{pager}",//removes the display 1-2 of 2 results
	));
?>

<?php endif ?>
<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'username',
//		'password',
		'email',
		'profile',
	),
));*/ ?>
