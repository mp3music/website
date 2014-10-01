<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading panel-title">Download <?= $query; ?> mp3</div>
	<!-- List group -->
	<ul class="list-group">
		<?php unset($results['response'][0]); ?>
		<?php foreach($results['response'] as $item) : ?>
			<li class="list-group-item list-group-item-custom">
                <div id="jp_container_1" class="jp-audio">
                   <strong class="track_title"><?= $item['title']; ?></strong> <br><span class="artist_name"><?= $item['artist']; ?></span>&nbsp;&nbsp;<span class="duration">(<?= gmdate("i:s", $item['duration']);?>)</span>
                    <div class="jp-type-single">
                        <div class="jp-gui jp-interface">
                            <ul class="jp-controls bs-glyphicons-list list-inline">
                                <li>
                                    <a class="jp-play glyphicon glyphicon-play voice" tabindex="1" href="<?= $item['url']; ?>"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="jp-pause glyphicon glyphicon-pause" tabindex="1"></a>
                                </li>
                                <li>
	                                <a class="glyphicon glyphicon-download-alt" href="/dl.php?link=<?= urlencode($item['url']); ?>&name=<?= urlclean($item['title'] .'-' . $item['artist'], '-'); ?>.mp3"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>