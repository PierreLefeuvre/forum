<?php $this->extend('/Forum/layout'); ?>

<?= $this->Html->css('topic/view.css') ?> 

<div class='row'>
    <div class='col-md-offset-2 col-md-8'>

        <h3><?= $topic->title ?></h3>

        <div class='topic'>

            <?php $i = 0; ?>
            <?php foreach($posts as $post): ?>
            <?php $c = (++$i % 2 == 0) ? 'c1' : 'c2'; ?>

            <div class="post <?= $c ?>">
                <div>
                    <div class='nickname'><?= $post->nickname ?></div>
                    <div class='pull-right'>
                        <?= $this->Date->formatDate($post->created, 'Y-m-d H:i:s'); ?>
                    </div>
                </div>
                <div>
                    <div class='post-message'><?= nl2br(htmlspecialchars($post->message)); ?></div>
                    
                    <div class='btn-edit pull-right'>
                        <?php if($post->ip == $_SERVER['REMOTE_ADDR']): ?>
                            <a href="/topic/edit/<?= $post->post_id ?>" >edit</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

            <a href="<?php echo $this->Paginator->generateUrl(['page' => '2']) ?>">2</a>

            <form action='/topic/addpost' method='POST' class='form-answer'>

                <div class='form-group'>
                    <textarea  name='message' class='form-control' rows='5' required></textarea>
                </div>

                <div class='form-inline'>
                    <input type='text' class='form-control pull-left' name='nickname' placeholder='pseudo' required />
                    <button type='submit' class='btn btn-default pull-right'  >Répondre</button>
                </div>
                 
                <input type='hidden' value="<?= $post_id ?>" name='topic_id' />
            </form>

        </div>
    </div>
</div>