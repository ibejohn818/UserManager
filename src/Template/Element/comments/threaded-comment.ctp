<?php


if(!empty($comment->parent_id)) {
    $reply_id = $comment->parent_id;
} else {
    $reply_id = $comment->id;
}
?>
<a name="comment<?= $comment->id ?>"></a>
<div class="threaded-comment">
    <div class="comment">
        <div class="row">
            <div class="col-xs-2">
                <div class="user">
                    <div class="user-avatar">
                        <img src="https://gravatar.com/avatar/<?= md5(strtolower(trim($post->user_account->email))) ?>?s=150&d=mm&r=x" alt="" class='gravatar' />
                    </div>
                    <div class="user-name">
                        <?= "{$comment->user_account->first_name} {$comment->user_account->last_name}" ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-10">
                <div class="date-time">
                    <?= $comment->created->format("F dS, Y @ g:ia") ?>
                </div>
                <div class="comment-text">
                    <?= Parsedown::instance()
                        ->setBreaksEnabled(true)
                        ->text($comment->comment) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-right btn-group reply-btn-group">
                        <button class="btn btn-success btn-sm" data-comment-id='<?= $reply_id ?>'>
                            <i class="fa fa-reply" aria-hidden="true"></i>
                                Reply
                        </button>
                        <button class="btn btn-primary btn-sm" onclick='$(".comment-form:eq(0)").find("textarea").focus();'>
                            <i class="fa fa-edit"></i>
                            New Comment
                        </button>
                        <?php
                            $formAjaxUrl = $this->UserManager->commentFormAjaxUri($comment->model, $comment->foreign_key, $this->request->here, ['parent_id'=>$reply_id]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="reply-form" data-comment-id='<?= $comment->id ?>'></div>
        <div class="replies">
            <?php if(count($comment->children)>0):
                    $children = new \Cake\Collection\Collection($comment->children);
                    $children = $children->sortBy("created", SORT_ASC);
            ?>
                <?php foreach($children as $k=>$v): ?>
                    <?= $this->element('UserManager.comments/threaded-comment',['comment'=>$v, "parent_id"=>$comment->id]) ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if(!isset($parent_id)): ?>
<script type="text/javascript">
    (function($) {
        var $reply = $("button[data-comment-id=<?= $comment->id ?>]");
        var $container = $("div[data-comment-id=<?= $comment->id ?>]");
        $reply.bind('click', function(e) {
            $(this).attr({"disabled": true});

            $.get('<?= $formAjaxUrl ?>', function(html) {
                var $form = $(html);
                $container.html($form);
                $(e.target).attr({"disabled": false});
                $form.find('textarea').focus();
            });
        });
    })(jQuery);
</script>
<?php endif; ?>
