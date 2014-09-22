<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MP3 Cooll</title>
	<!-- Bootstrap -->
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="/assets/css/custom-styles.css" rel="stylesheet">
	<link href="/assets/css/select2.css" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="container container-custom">
	<div class="row">
		<a href="/" class="col-lg-2 col-sm-6 col-xs-12 navbar-brand">
			<img src="/assets/images/logo.jpg">
		</a>
		<form class="col-lg-10 col-sm-4 navbar-form navbar-left search-input">
			<input id="e22" type="text" placeholder="Search..." class="form-control input-text">
			<button class="btn btn-primary" type="button"><span> Search </span></button>
		</form>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-xs-12 blog-main">
			<div class="blog-post blog-post-content">
				<?= $this->render($page . '.php'); ?>
			</div><!-- /.blog-post -->
		</div><!-- /.blog-main -->

		<div class="col-sm-4 col-xs-12 blog-sidebar">
			<div class="sidebar-module sidebar-archives">
				<h4 class="label label-info label-info-custom">Archives</h4>
				<p>
					mp3cooll.com is an easy way to listen music.
					You can find your favorite songs in our multimillion database of
					quality mp3 links. We provide fast and relevant search.
					You can also post music in your blog or personal site.
					Hope you enjoy staying here!
				</p>
			</div>
			<div class="sidebar-module sidebar-social">
				<h4 class="label label-info label-info-custom">Elsewhere</h4>
				<div class="addthis_native_toolbox"></div>
			</div>

			<div class="sidebar-module sidebar-now-playing">
				<h4 class="label label-info label-info-custom">Now Playing</h4>
				<div class="list-group">
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Porta ac consectetur ac</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Vestibulum at eros</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Link mp3 music</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Vestibulum at eros</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-star glyphicon-blue" href="#">
						<span>Morbi leo risus</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Link mp3 music</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Dapibus ac facilisis in</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Link mp3 music</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Dapibus ac facilisis in</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Link mp3 music</span>
					</a>
					<a class="list-group-item glyphicon glyphicon-music glyphicon-blue" href="#">
						<span>Link mp3 music</span>
					</a>
				</div>
				<a class="link-more" href="#">More</a>
			</div>
		</div><!-- /.blog-sidebar -->
	</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/select2.min.js"></script>
<script src="/assets/js/searchsuggestion.js"></script>
</body>
</html>