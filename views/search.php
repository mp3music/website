<div class="panel panel-default">
	<!-- Default panel contents -->
	<h1 class="panel-heading panel-title">Download <?= $query; ?> mp3</h1>
	<!-- List group -->
	<ul class="list-group playing">
		<?php if (count($results) && isset($results['result'])) : ?>

			<?php foreach ($results['result'] as $item) : ?>
				<?php $downloadUrl = '/dl.php?link=' . urlencode($item['url']) . '&name=' . urlclean($item['title'] . '-' . $item['artist']['name'],
						'-') . '.mp3'; ?>
				<li class="list-group-item list-group-item-custom">
					<div id="jp_container_1" class="jp-audio">
						<strong class="track_title"><?= s($item['title'], 70); ?></strong>
						<br><span class="artist_name"><?= s($item['artist']['name'], 70); ?></span>&nbsp;&nbsp;<span class="duration">(<?= $item['duration']; ?>)</span>

						<div class="jp-type-single">
							<div class="jp-gui jp-interface">
								<ul class="jp-controls bs-glyphicons-list list-inline">
									<li>
										<a class="sm2_button sm2_play inline-playable" tabindex="1" data-src="<?= $downloadUrl . '&play=1'; ?>"></a>
									</li>
									<li>
										<a class="download-button" href="<?= $downloadUrl; ?>"></a>
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