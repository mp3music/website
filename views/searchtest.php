<div class="panel panel-default">
	<!-- Default panel contents -->
	<h1 class="panel-heading panel-title">Download <?= $query; ?> mp3</h1>
	<!-- List group -->
	<ul class="list-group playing">
		<?php if (count($results)) : ?>
			<?php foreach ($results as $item) : ?>
				<li class="list-group-item list-group-item-custom">
					<div id="jp_container_1" class="jp-audio">
						<strong class="track_title"><?= s($item['title'], 60); ?></strong>
						<br><span class="artist_name"><?= s($item['artist'], 60); ?></span>&nbsp;&nbsp;<span class="duration">(<?= $item['duration']; ?>)</span>

						<div class="jp-type-single">
							<div class="jp-gui jp-interface">
								<ul class="jp-controls bs-glyphicons-list list-inline">
									<li>
										<a class="sm2_button sm2_play inline-playable" tabindex="1" data-src="<?= $item['url']; ?>"></a>
									</li>
									<li>
										<a class="download-button" data-id="<?= $item['_id']; ?>" href="<?= $item['url']; ?>"></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>
<br><br>