<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading panel-title">The hot 100</div>
	<!-- List group -->
	<ul class="list-group">
		<?php foreach($results as $item) : ?>
		<li class="list-group-item list-group-item-custom">
            <div id="jp_container_1" class="jp-audio">
                <a href="/<?= urlclean($item->artist . ' ' . $item->chart_item_title, '-'); ?>.html" class="list-group-href"><?= $item->artist; ?><br><strong><?= $item->chart_item_title; ?></strong></a>
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