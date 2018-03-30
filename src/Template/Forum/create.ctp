<?php $this->extend('/Forum/layout'); ?>

<?= $this->Html->css('topic/create.css') ?>

<?= $this->form->create(null,['url'=>$this->url->build(['_name' => 'addTopic'])]) ?>

    <div class='form-group'>
        <label for='title'><?= __('Title') ?></label>
        <?= $this->form->text('title', ['class' => 'form-control', 'required']); ?>
    </div>

    <div class='form-group'>
        <label for='nickname'><?= __('Nickname') ?></label>
        <?= $this->form->text('nickname', [
            'class' => 'form-control', 
            'required',
            'value'=> $this->request->session()->read('user.nickname'),
            'placeholder' => __('Nickname')
            ]); ?>
    </div>

    <div class='form-group'>
        <label for='message'><?= __('Message') ?></label>
        <?= $this->form->textarea('message', ['class' => 'form-control','required','rows' => '4']) ?>        
    </div>

    <?= $this->form->button('OK', ['class'=>'btn btn-default']) ?>

<?= $this->form->end(); ?>