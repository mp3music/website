<div class="panel panel-default">
	<!-- Default panel contents -->
	<h1 class="panel-heading panel-title">Download <?= $query; ?> mp3</h1>
	<!-- List group -->
	<ul class="list-group">
		<?php if (isset($results['response'])) : ?>
			<?php unset($results['response'][0]); ?>
			<?php foreach ($results['response'] as $item) : ?>
				<?php $downloadUrl = '/dl.php?link=' . urlencode($item['url']) . '&name=' . urlclean($item['title'] . '-' . $item['artist'],
						'-') . '.mp3'; ?>
				<li class="list-group-item list-group-item-custom">
					<div id="jp_container_1" class="jp-audio">
						<strong class="track_title"><?= s($item['title'], 70); ?></strong>
						<br><span class="artist_name"><?= s($item['artist'], 70); ?></span>&nbsp;&nbsp;<span class="duration">(<?= gmdate("i:s", $item['duration']); ?>)</span>

						<div class="jp-type-single">
							<div class="jp-gui jp-interface">
								<ul class="jp-controls bs-glyphicons-list list-inline">
									<li>
										<a class="sm2_button inline-playable" tabindex="1" href="<?= $item['url']; ?>">
											&nbsp;&nbsp;&nbsp;&nbsp;</a>
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

<script src="/assets/js/soundmanager2.js"></script>
<script src="/assets/js/mp3-player-button.js"></script>
<script type="text/javascript">
	soundManager.setup({
		useFlashBlock: true,
		url: '/assets/js/swf/soundmanager2.swf'
	});
</script>