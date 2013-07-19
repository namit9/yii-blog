<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
//	'Posts'=>array('index'),
	'Manage',
);

/*$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();//toggles display property
	return true;
});
$('.search-form form').submit(function(){
	$('.search-form').toggle();
	$('#post-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Posts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
//	'ajaxUpdate'=>false,//uncomment to get full get variables in url
/*	'columns'=>array(
		'id',
		'title',
		'content',
		'tags',
		'status',
		'create_time',
		/*
		'update_time',
		'author_id',
		*//*
		array(
			'class'=>'CButtonColumn',
		),
	),*/
'columns'=>array(
        array(
            'name'=>'title',
            'type'=>'raw',//only title and not full html
            'value'=>'CHtml::link(CHtml::encode($data->title), $data->url)'
        ),
        array(
            'name'=>'status',
            'value'=>'Lookup::item("PostStatus",$data->status)',
            'filter'=>Lookup::items('PostStatus'),//dropdown menu of possible values
        ),
        array(
            'name'=>'create_time',
            'type'=>'datetime',
            'filter'=>false,//so that create_time not searched
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    ),
)); ?>
