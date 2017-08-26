<div class="threaded-comment">
	<div class="comment clearfix">
		<div class="date">
			<a name='comment-<?= $comment->id ?>'></a>
			<?= $comment->created->format("F dS, Y @ g:ia") ?>
		</div>
		<div class="comment-text">
			<?= Parsedown::instance()
				->setBreaksEnabled(true)
				->text($comment->comment) ?>
		</div>
		<div class="user clearfix">
			<div class="pull-left">
				<img src="https://gravatar.com/avatar/<?= md5(strtolower(trim($post->user_account->email))) ?>?s=75&d=mm&r=x" alt="" class='gravatar' />
					<?= "{$comment->user_account->first_name} {$comment->user_account->last_name}" ?>
			</div>
			<div class="pull-right reply-btn-div">
			<button type="button" class="btn btn-sm btn-default" data-reply-to='<?= $comment->id ?>'>Reply</button>
			</div>
		</div>
	</div>
	<div id='comment-reply-form-<?= $comment->id ?>'></div>
	<?php if(count($comment->children)>0): ?>
		<?php foreach($comment->children as $k=>$v): ?>
			<?= $this->element('UserManager.comments/threaded-comment',['comment'=>$v, "parent_id"=>$comment->id]) ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
