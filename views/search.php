<div class="panel panel-primary">
	<!-- Default panel contents -->
	<div class="panel-heading panel-title">The hot 100</div>
	<!-- List group -->
	<ul class="list-group">
		<?php foreach($results as $item) : ?>
			<li class="list-group-item list-group-item-custom">
				<?= $item['artist']; ?><br><strong><?= $item['title']; ?></strong>
				<span><?= $item['duration']; ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
</div>