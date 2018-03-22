<?php $this->extend('/Forum/layout'); ?>


<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <form action="<?= $this->url->build(['_name' => 'addTopic']) ?>" method='POST'>

            <div class='form-group'>
                <label><?= __('Title') ?></label>
                    <input type='text' class='form-control' name='title' required/>
            </div>

            <div class='form-group'>
                <label>Pseudo </label>
                <input type='text' class='form-control' name='nickname' required/>
            </div>

            <div class='form-group'>
                <label>Message </label>
                <textarea class='form-control' name='message' required rows='4'></textarea>
            </div>

            <input type='submit' class='btn btn-default' value='OK'/>

        </form>

    </div>
</div>