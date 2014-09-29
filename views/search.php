<script src="/assets/js/jquery.jplayer.min.js"></script>
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading panel-title">Download <?= $query; ?> mp3</div>
	<!-- List group -->
	<ul class="list-group">
		<?php foreach($results['result'] as $item) : ?>
			<li class="list-group-item list-group-item-custom">
                <div id="jp_container_1" class="jp-audio">
                    <a href="<?= $item['url']; ?>" download="true"><?= $item['artist']['name']; ?><br><strong><?= $item['title']; ?></strong></a>
    <!--				-<span>--><?//= $item['duration']; ?><!--</span>-->
                    <span class="jp-duration"></span>
                    <div class="jp-type-single">
                        <div class="jp-gui jp-interface">
                            <ul class="jp-controls bs-glyphicons-list list-inline">
                                <li>
                                    <a href="javascript:;" class="jp-play glyphicon glyphicon-play" tabindex="1"></a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="jp-pause glyphicon glyphicon-pause" tabindex="1"></a>
                                </li>
                                <li class="glyphicon glyphicon-download-alt download-button"></li>
                            </ul>
                        </div>
                    </div>
                </div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>