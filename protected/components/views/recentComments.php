<ul>
	<?php foreach($this->getRecentComments() as $comment): ?>
	<li><?php echo $comment->AuthorLink; ?> on
		<?php echo CHtml::link(CHtml::encode($comment->post->title), $comment->getUrl()); ?>
	</li>
	<?php endforeach; ?>
</ul>
