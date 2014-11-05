<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <meta name="description" content="<?= $description; ?>">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom-styles.min.css" rel="stylesheet">
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
                <input id="e22" type="text" class="form-control" placeholder="Type in a song title or artist name" value="<?= isset($query) ? $query : ''; ?>">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-info">Search</button>
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
        </div>
        <!-- /.blog-main -->

        <div class="col-sm-4 col-xs-12 blog-sidebar">
            <div class="sidebar-module sidebar-archives">
                <p>
                    mp3cooll.com is an easy way to listen music, watch video and download mp3.
                    You can find your favorite songs in our multimillion database of
                    quality mp3 links. Download free mp3 songs on your android or iPhone devices. We provide fast and
                    relevant search.
                    Hope you enjoy staying here!
                </p>
            </div>
            <div style="width:310px; margin-top:20px; text-align:right; padding-left:2px;">
                <script type="text/javascript">(function() {
                        if (window.pluso)if (typeof window.pluso.start == "function") return;
                        if (window.ifpluso==undefined) { window.ifpluso = 1;
                            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                            var h=d[g]('body')[0];
                            h.appendChild(s);
                        }})();</script>
                <div class="pluso" data-background="transparent" data-options="medium,round,line,horizontal,counter,theme=04" data-services="facebook,twitter,google,vkontakte,odnoklassniki" data-url="http://mp3cooll.com/" data-title="<?= $title; ?>" data-description="<?= $description; ?>"></div>
            </div>

            <?php if (isset($video) && $video != null) : ?>
                <div class="sidebar-module sidebar-now-playing">
                    <div class="label label-info label-info-custom"><?= $query; ?> video</div>
                    <?= $video; ?>
                </div>
            <?php endif; ?>

            <div class="sidebar-module sidebar-now-playing">
                <div class="label label-info label-info-custom">Now playing</div>
                <ul class="list-inline">
                    <?php $artists = getLastQueries(20); ?>
                    <?php foreach ($artists as $artist) : ?>
                        <li>
                            <a href="/<?= urlclean($artist, '-'); ?>.html">
                                <?= $artist; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div><a href="/now.html">more</a></div>
            </div>
        </div>
        <!-- /.blog-sidebar -->
    </div>
</div>

<div id="jquery_jplayer"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $("#search_form").submit(function () {
        var val = $('#e22').val();
        if (val.length >= 2) {
            ga('send', 'event', 'button', 'search');
            val = val.replace(/[\s\.\!\@\#\$\%\^\&\*\(\)\\\}\]\{\[\'\"\;\:]/g, "-").toLowerCase();
            window.location = '/' + val.replace(/--/g, "-") + '.html';
        }
        return false;
    });

    $(".inline-playable").click(function(){
        ga('send', 'event', 'button', 'play');
    });
    $(".download-button").click(function(){
        ga('send', 'event', 'button', 'download');
    });
</script>
</body>
</html>