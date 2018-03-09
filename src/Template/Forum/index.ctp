<?= $this->Html->css('topic/index.css') ?>

<?php $this->extend('/Forum/layout'); ?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php foreach($topics['result'] as $topic): ?>

            <div class="thumbnail">

                <a href="/topic/view/<?= $topic->topic_id ?>">
                    <span class='title'><?= mb_strimwidth($topic->title, 0, 95, '...') ?></span>
                </a>

                <div class='pull-right topic-info' >

                    <div class='created-date'><?= $this->Date->formatDate($topic->created); ?></div>

                    <div class='nickname'>
                        <?= mb_strimwidth($topic->nickname, 0, 17, "...") ?>
                    </div>
                    
                    <div class='div-delete'>
                        <?php if($topic->ip == $_SERVER['REMOTE_ADDR']): ?>
                            <a href="/topic/delete/<?=  $topic->topic_id; ?>" class='btn-delete'>X</a>
                        <?php endif; ?>
                    </div>
                
                </div>
            
            </div> <!-- thumbnail -->
        
        <?php endforeach; ?>
        
        
    <div>
    Page:
        <?php for($i=1; $i <= $topics['pageCount']; $i++): ?>
            <a href="<?php echo $this->Paginator->generateUrl(['page' => $i]) ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    
    </div>
    <div class='col-md-2'>
        <a href='/topic/create' type='button' class='btn btn-default'>+ Topic</a>
    </div>
</div>

