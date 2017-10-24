<?php

if(!isset($return_uri)) {
	$return_uri = $_SERVER['REQUEST_URI'];
}
?>
<?php
echo $this->Form->create(new \UserManager\Model\Entity\UserComment(),[
	'url'=>[
		'plugin'=>'UserManager',
		'controller'=>'Comments',
		'action'=>'create',
		'prefix'=>false
    ],
    'class'=>'comment-form'
	]);
?>
<?php
	echo $this->Form->input("return_uri",['type'=>'hidden','value'=>$return_uri]);
	echo $this->Form->input("model",['type'=>'hidden','value'=>$model]);
	echo $this->Form->input("foreign_key",['type'=>'hidden','value'=>$foreign_key]);
	if(isset($parent_id) && $parent_id) {
		echo $this->Form->input("parent_id",['type'=>'hidden','value'=>$parent_id]);
	}

?>

<?= $this->Form->input("comment",['type'=>'textarea']) ?>
<div class="submit clearfix">
	<div class="markdown-legend pull-left">
		Markdown Formatting	Accepted. ( <a href='https://en.wikipedia.org/wiki/Markdown#Example' target='_blank'>View Examples</a> )
	</div>

	<div class="btn-group pull-right">
		<button type="submit" class="btn btn-primary">Add Comment</button>
	</div>
</div>
<?php
	echo $this->Form->end();
?>
<script type="text/javascript">
	$("form.comment-form textarea.form-control").bind('keyup',function(e) {
		$(this).height(0).height(this.scrollHeight);
	})
</script>
