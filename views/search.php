<script src="/assets/js/jquery.jplayer.min"></script>
<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading panel-title">Download <?= $query; ?></div>
	<!-- List group -->
	<ul class="list-group">
		<?php foreach($results['result'] as $item) : ?>
			<li class="list-group-item list-group-item-custom">
				<a href="<?= $item['url']; ?>" download="true"><?= $item['artist']['name']; ?><br><strong><?= $item['title']; ?></strong></a>
				<span><?= $item['duration']; ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</div>