<?php $this->extend('/Forum/layout'); ?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <form action="/topic/edit/<?= $post->post_id ?>" method='POST' class='form-edit'>
            <div class='form-group'>
                <textarea  name='message' class='form-control' rows='4' required><?= $post->message ?></textarea>
            </div>

            <div class='form-inline'>
                
                <button type='submit' class='btn btn-default pull-right'  >Edit</button>
            </div>
            
            <input type='hidden' value="<?= $post->post_id ?>" name='topic_id' />
        </form>

    </div>
</div>