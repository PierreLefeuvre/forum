<?php $this->extend('/Forum/layout'); ?>

<?= $this->form->create($post, ['class' =>'form-edit', 'type'=> 'post', 'url' => $this->url->build(['_name' => 'editPost', 'post_id' => $post->post_id, 'topic_id' => $post->topic_id])]); ?>

    <div class='form-group'>
        <?= $this->form->textarea('message', ['class'=>'form-control', 'rows'=> '9', 'required']) ?> 
    </div>

    <div class='form-inline'>
        <?= $this->form->button('Edit', ['class'=>'btn btn-default pull-right']) ?>
    </div>
    
    <?= $this->form->hidden('post_id', ['value' => $post->post_id]) ?>
    <?= $this->form->hidden('topic_id', ['value' => $post->topic_id]) ?>

    <br><br>
<?= $this->form->end(); ?>