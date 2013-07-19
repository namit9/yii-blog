<ul>
    <li><?php echo CHtml::link('Create New Post',array('post/create')); ?></li>
    <li><?php echo CHtml::link('Manage Posts',array('post/admin')); ?></li>
    <li><?php echo CHtml::link('Approve Comments',array('comment/index'))
        . ' (' . Comment::model()->pendingCommentCount . ')'; ?></li>
    <li><?php echo CHtml::link('Logout',array('site/logout')); ?></li>
    <li><?php //echo CHtml::link('Delete account','#',array('confirm'=>'Are you sure you want to delete your account?','submit'=>array('delete','id'=>Yii::app()->user->id))); ?></li>
</ul>
