<?php $this->extend('/Forum/layout'); ?>

<?= $this->Html->css('topic/view.css') ?> 

<h3><?= $topic->title ?></h3>

<div class='topic'>

    <?php $i = 0; ?>
    <?php foreach($posts['result'] as $post): ?>
    <?php $c = (++$i % 2 == 0) ? 'c1' : 'c2'; ?>

    <div class="post <?= $c ?>">
        <div>
            <div class='nickname'><?= $post->nickname ?></div>
            <div class='post-date pull-right'>
                <?= $this->Date->formatDate($post->created, 'Y-m-d H:i:s'); ?>
            </div>
        </div>
        <div>
            <div class='post-message'><?= nl2br(htmlspecialchars($post->message)); ?></div>
            
            <div class='btn-edit pull-right'>
                <?php if($post->ip == $_SERVER['REMOTE_ADDR']): ?>
                    <a href="<?= $this->url->build(['_name'=>'editPost', 'post_id' => $post->post_id, 'topic_id' => $post->topic_id]) ?>" ><?= __('edit') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php endforeach; ?>

    <div class='page'>
    Page:
        <?php for($i=1; $i <= $posts['pageCount']; $i++): ?>
            <?= $this->html->link($i, ['page' => $i]) ?>
        <?php endfor; ?>
    </div>

    <?= $this->form->create(null, ['class' =>'form-answer', 'type'=> 'post', 'url' => $this->url->build(['_name' => 'addPost'])]); ?>

        <div class='form-group'>
            <?= $this->form->textarea('message', ['class'=>'form-control', 'rows'=>'5', 'required']) ?>
        </div>

        <div class='form-inline'>
            <?= $this->form->text('nickname', [
                'class'=>'form-control pull-left', 
                'placeholder'=> __('Nickname'), 
                'value' => $this->request->session()->read('user.nickname'),
                'required'
                ]) ?>
        </div>

        <div class='form-inline'>
            <?= $this->form->button(__('Reply'), ['id'=>'btn-reply', 'class'=> 'btn btn-default']) ?>
        </div>
        
        <?= $this->form->hidden('topic_id', ['value' => $post_id]) ?>
        
        <br><br>

    <?= $this->form->end(); ?>

</div>