<?php
/* @var $this PostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Posts',
);

/*$this->menu=array(
	array('label'=>'Create Post', 'url'=>array('create')),
	array('label'=>'Manage Post', 'url'=>array('admin')),
);*/
?>

<?php if(!empty($_GET['tag'])): ?>
<h1>Posts Tagged with <i><?php echo CHtml::encode($_GET['tag']); ?></i></h1>
<?php endif; ?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,//left side inbuilt prop of clistview,right side from controller
	'itemView'=>'_view',//rendered once for every data item
	'template'=>"{items}\n{pager}",//data item list and pager,works w/o template also
)); ?>
