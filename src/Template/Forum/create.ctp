<?php $this->extend('/Forum/layout'); ?>

<?= $this->Html->css('topic/create.css') ?>

<form action="<?= $this->url->build(['_name' => 'addTopic']) ?>" method='POST'>

    <div class='form-group'>
        <label><?= __('Title') ?></label>
            <input type='text' class='form-control' name='title' required/>
    </div>

    <div class='form-group'>
        <label><?= __('Username') ?></label>
        <input type='text' class='form-control' name='nickname' required/>
    </div>

    <div class='form-group'>
        <label><?= __('Message') ?></label>
        <textarea class='form-control' name='message' required rows='4'></textarea>
    </div>

    <input type='submit' class='btn btn-default' value='OK'/>

</form>