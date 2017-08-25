<div class="threaded-comment">
	<div class="comment clearfix">
		<div class="date">
			<?= $comment->created->format("F dS, Y @ g:ia") ?>
		</div>
		<div class="comment-text">
			<?= $comment->comment ?>
		</div>
		<div class="user">
			<img src="https://gravatar.com/avatar/<?= md5(strtolower(trim($post->user_account->email))) ?>?s=75&d=mm&r=x" alt="" class='gravatar' />
			<strong>
				<?= "{$comment->user_account->first_name} {$comment->user_account->last_name}" ?>
			</strong>
		</div>
	</div>
	<?php if(count($comment->children)>0): ?>
		<?php foreach($comment->children as $k=>$v): ?>
			<?= $this->element('UserManager.comments/threaded-comment',['comment'=>$v, "parent_id"=>$comment->id]) ?>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
