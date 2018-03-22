<style>
    body{
        background-color: #faf7fc;
    }
</style>
<a href="<?= $this->url->build(['_name'=>'forum']) ?>">
    <h1><?= __('Forum') ?></h1>
</a>



<div class='dropdown'>

    <button class='btn btn-default dropdown-toggle' type='button'  id='dropDownMenu1' data-toggle='dropdown' 
    aria-haspopup='true' aria-expanded='true' >
        <?= $this->lang->getLang() ?>
        <span class='caret'></span>
    </button>

    <ul class='dropdown-menu' aria-labelledby='dropDownMenu1'>
        <?php foreach(['es', 'fr'] as $lang): ?>
            <li class="<?= $lang == $this->lang->getLang() ? 'active' : ''  ?>">
                <?= $this->html->link($lang, ['lang'=> $lang]) ?>
            </li>
        <?php endforeach; ?>
    </ul>    
</div>

<?= $this->fetch('content') ?>