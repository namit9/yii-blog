<?php
/* @var $this CommentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Comments',
);

/*$this->menu=array(
	array('label'=>'Create Comment', 'url'=>array('create')),
	array('label'=>'Manage Comment', 'url'=>array('admin')),
);*/
?>

<h1>Comments</h1>
<?php //echo is_string(Comment::model()->allowed("11"))?'yes':'no'; ?>
<?php //echo is_string(Yii::app()->user->id)?'yes':'no'; ?>
<?php //echo Comment::model()->allowed("11"); ?>
<?php //echo Yii::app()->user->id; ?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>'{items}',
)); ?>
