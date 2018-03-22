<?php $this->extend('/Forum/layout'); ?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <form action="<?= $this->url->build(['_name' => 'editPost', 'post_id' => $post->post_id, 'topic_id' => $post->topic_id]) ?>" method='POST' class='form-edit'>
            <div class='form-group'>
                <textarea  name='message' class='form-control' rows='9' required><?= $post->message ?></textarea>
            </div>

            <div class='form-inline'>
                
                <button type='submit' class='btn btn-default pull-right'  >Edit</button>
            </div>
            
            <input type='hidden' value="<?= $post->post_id ?>" name='post_id' />
            <input type='hidden' value="<?= $post->topic_id ?>" name='topic_id' />
        </form>

    </div>
</div>