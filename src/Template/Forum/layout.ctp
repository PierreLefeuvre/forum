<div id='header'>
    <a href="<?= $this->url->build(['_name'=>'indexForum']) ?>" >
        <h1><?= __('Forum') ?></h1>
    </a>
</div>

<div class="row">

    <!-- colonne de gauche -->
    <div class='col-xs-4 col-sm-4 col-md-2 col-lg-1'>
        <!-- choix de la langue -->
        <div class='dropdown'>
            <button class='btn btn-default dropdown-toggle' type='button'  id='dropDownMenu1' data-toggle='dropdown' 
            aria-haspopup='true' aria-expanded='true' >
                <?= $this->lang->getLang() ?>
                <span class='caret'></span>
            </button>
            <ul class='dropdown-menu' aria-labelledby='dropDownMenu1'>
                <?php foreach(['es', 'fr', 'en'] as $lang): ?>
                    <li class="<?= $lang == $this->lang->getLang() ? 'active' : ''  ?>">
                        <?= $this->html->link($lang, ['lang'=> $lang]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>    
        </div>
    </div>

    <!-- s'affiche uniquement sur les petit ecran -->
    <div class='col-xs-4 col-sm-4 hidden-lg hidden-md pull-right'>
        <!-- bouton pour ajouter un topic -->
        <a href="<?= $this->url->build(['_name'=>'createTopic']) ?>" type='button' class='btn btn-default pull-right'>+ <?= __("Topic") ?></a>
    </div>

    <!-- contenu principale -->
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10">
        <div class='content'>
            <?= $this->fetch('content') ?>
        </div>
    </div>

    <!-- colonne de droite -->
    <div class='col-md-2 hidden-xs hidden-sm col-lg-1'>
        <!-- bouton pour ajouter un topic -->
        <a href="<?= $this->url->build(['_name'=>'createTopic']) ?>" type='button' class='btn btn-default'>+ <?= __("Topic") ?></a>
    </div>
    
</div>