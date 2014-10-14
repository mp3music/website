<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>
	<meta name="description" content="<?= $description; ?>">
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/custom-styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
			(i[r].q = i[r].q || []).push(arguments)
		}, i[r].l = 1 * new Date();
		a = s.createElement(o),
			m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-55375266-1', 'auto');
	ga('send', 'pageview');
</script>
<div class="navbar navbar-default navbar-fixed-top search-bar-custom" role="navigation">
	<div class="container container-custom">
		<a href="/" class="logo-block navbar-brand">
			<span class="logo" title="Free mp3 download">MP3Cooll</span>
		</a>

		<form class="bs-example bs-example-form" id="search_form">
			<div class="input-group search-input">
				<input id="e22" type="text" class="form-control">
          <span class="input-group-btn">
            <button type="button" class="btn btn-info">Search</button>
          </span>
			</div>
		</form>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-xs-12 blog-main">
			<div class="blog-post blog-post-content">
				<?= $this->render($page . '.php'); ?>
			</div>
			<!-- /.blog-post -->

			<div class="sidebar-module sidebar-now-playing">
				<div class="label label-info label-info-custom">Users search</div>
				<ul class="list-inline">
					<?php $requests = getLastQueries(); ?>
					<?php foreach ($requests as $request) : ?>
						<li>
							<a href="/<?= urlclean($request, '-'); ?>.html">
								<?= $request; ?> mp3
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<br>
		</div>
		<!-- /.blog-main -->

		<div class="col-sm-4 col-xs-12 blog-sidebar">
			<div class="sidebar-module sidebar-archives">
				<p>
					mp3cooll.com is an easy way to listen music and download mp3.
					You can find your favorite songs in our multimillion database of
					quality mp3 links. Download free mp3 songs on your android or iPhone devices. We provide fast and
					relevant search.
					Hope you enjoy staying here!
				</p>
			</div>
			<div style="width:310px; margin-top:20px; text-align:right; padding-left:2px;">
				<g:plusone size="medium"></g:plusone>
				<script type="text/javascript">
					(function () {
						var po = document.createElement('script');
						po.type = 'text/javascript';
						po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(po, s);
					})();
				</script>
				<iframe
					src="http://www.facebook.com/plugins/like.php?app_id=221027461249362&amp;href=http://mp3cooll.com<?= $_SERVER['REQUEST_URI']; ?>&amp;send=false&amp;layout=button_count&amp;width=95&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21"
					scrolling="no" frameborder="0"
					style="border:none; overflow:hidden; width:85px; height:21px; margin-right:8px;"
					allowTransparency="true"></iframe>
				<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal"
				   data-via="mp3cooll.com">Tweet</a>
				<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			</div>

			<div class="sidebar-module sidebar-now-playing">
				<div class="label label-info label-info-custom">Top singers</div>
				<ul class="list-inline">
					<?php $artists = randomArtists(20); ?>
					<?php foreach ($artists as $artist) : ?>
						<li>
							<a href="/<?= urlclean($artist, '-'); ?>.html">
								<?= $artist; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="sidebar-module sidebar-now-playing">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.0";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
				<div class="fb-like-box" data-href="https://www.facebook.com/pages/Mp3Cooll/342836852560201" data-height="300" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
			</div>
		</div>
		<!-- /.blog-sidebar -->
	</div>
</div>

<div id="jquery_jplayer"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$("#search_form").submit(function () {
		var val = $('#e22').val();
		if (val.length > 3) {
			val = val.replace(/[\s\.\!\@\#\$\%\^\&\*\(\)\\\}\]\{\[\'\"\;\:]/g, "-").toLowerCase();
			window.location = '/' + val.replace(/--/g, "-") + '.html';
		}
		return false;
	});
</script>
</body>
</html>