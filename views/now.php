<div class="panel panel-default">
    <h1 class="panel-heading panel-title">Now playing mp3</h1>
    <ul class="list-group">
        <?php foreach($results as $item) : ?>
            <li class="list-group-item list-group-item-custom">
                <a href="/<?= urlclean($item, '-'); ?>.html" class="list-group-href"><span class="artist_name"><?= $item; ?></span></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>