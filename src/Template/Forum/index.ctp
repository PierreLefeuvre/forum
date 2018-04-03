<?= $this->Html->css('topic/index.css') ?>

<?php $this->assign('title', 'index'); ?>

<?php $this->extend('/Forum/layout'); ?>

        <?php foreach($topics['result'] as $topic): ?>

            <div class="thumbnail">

                <a href="<?= $this->url->build(['_name'=>'viewTopic', 'id'=> $topic->topic_id]) ?>">
                    <span class='title'><?= $topic->title ?></span>
                </a>

                <div class='pull-right topic-info' >

                    <div class='created-date'><?= $this->Date->formatDate($topic->modified); ?></div>

                    <div class='nickname'>
                        <?= $topic->nickname ?>
                    </div>
                    
                    <div class='div-delete'>
                        <?php if($topic->ip == $_SERVER['REMOTE_ADDR']): ?>
                        
                            <a href="<?= $this->url->build(['_name'=>'deleteTopic', 'id'=> $topic->topic_id]) ?>" class='btn-delete'>X</a>
                        <?php endif; ?>
                    </div>
                
                </div>
            
            </div> <!-- thumbnail -->
        
        <?php endforeach; ?>
        
    <br>
    <div class='page'>
    <?= __("Page") ?>:
        <?php for($i=1; $i <= $topics['pageCount']; $i++): ?>
            <a href="<?php echo $this->Paginator->generateUrl(['page' => $i]) ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>




