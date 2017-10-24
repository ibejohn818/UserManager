<?php

if(isset($options['parent_id'])) {
    $parent_id = $options['parent_id'];
} else {
    $parent_id = false;
}

?>
<?= $this->element("UserManager.comments/comment-form",compact(
    "model", "foreign_key", "parent_id", "return_uri"
)); ?>
