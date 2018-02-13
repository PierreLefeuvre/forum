<style>
    .thumbnail{
        margin-bottom: 0px;
    }
    .bold{
        font-weight: bold;
    }
</style>

<h1>Forum</h1>
<div class="row">
    <div class="col-md-offset-2 col-md-6">
        <?php foreach($topics as $topic): ?>

        <a href="/topic/view/<?= $topic->topic_id ?>">
            <div class="thumbnail">
            <span class='bold'><?= $topic->nickname ?></span>
            -
            <span><?= $topic->title ?></span>
            </div>
        </a>

        <?php endforeach; ?>
    </div>
</div>