<?php 
$this->breadcrumbs=array(
	$_GET["r"],
);

$this->widget('zii.widgets.CListView',array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view',
));	
