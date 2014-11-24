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
    <meta http-equiv="Cache-Control" content="max-age=10, must-revalidate"/>
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

        <form id="search_form" action="/search">
            <div class="input-group search-input">
                <input id="e22" name="q" type="text" class="form-control"
                       placeholder="Type in a song title or artist name" value="<?= isset($query) ? $query : ''; ?>">
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
        </div>

        <div class="col-sm-4 col-xs-12 blog-sidebar">
            <div class="sidebar-module sidebar-archives">
                <p>
                    mp3cooll.com is an easy way to listen music, watch video and download mp3.
                    You can find your favorite songs in our multimillion database of
                    quality mp3 links. Download free mp3 songs on your android or iPhone devices. We provide fast and
                    relevant search.
                    Hope you enjoy staying here!
                </p>

                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=368859276603169&version=v2.0";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like" data-href="https://www.facebook.com/pages/Mp3Cooll/342836852560201"
                     data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                <a href="https://www.facebook.com/mp3coollmusic" target="_blank">Mp3Cooll Facebook
                    Page</a>
            </div>

            <div style="width:310px; margin-top:20px; text-align:right; padding-left:2px;">
                <script type="text/javascript">(function () {
                        if (window.pluso)if (typeof window.pluso.start == "function") return;
                        if (window.ifpluso == undefined) {
                            window.ifpluso = 1;
                            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                            s.type = 'text/javascript';
                            s.charset = 'UTF-8';
                            s.async = true;
                            s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://share.pluso.ru/pluso-like.js';
                            var h = d[g]('body')[0];
                            h.appendChild(s);
                        }
                    })();</script>
                <div class="pluso" data-background="transparent"
                     data-options="medium,round,line,horizontal,counter,theme=04"
                     data-services="facebook,twitter,google,vkontakte,odnoklassniki"
                     data-url="http://mp3cooll.com<?= $_SERVER['REQUEST_URI']; ?>" data-title="<?= $title; ?>"
                     data-description="<?= $description; ?>"></div>
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
    </div>
</div>
<audio preload></audio>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(".inline-playable").click(function () {
        ga('send', 'event', 'button', 'play');
    });
    $(".download-button").click(function () {
        ga('send', 'event', 'button', 'download');
    });
    $(".btn-info").click(function () {
        ga('send', 'event', 'button', 'search');
    });
</script>

<?php if (isset($query)) : ?>
    <script src="/assets/js/audiojs/audio.min.js"></script>
    <script type="text/javascript">
        $(function () {
            // Setup the player to autoplay the next track
            var a = audiojs.createAll({
                trackEnded: function () {
                    var next = $('ul li a.sm2_button').next();
                    if (!next.length) next = $('ul li a.sm2_button').first();
                    next.addClass('playing').siblings().removeClass('playing');
                    $(this).addClass('sm2_paused').removeClass('sm2_play');
                    audio.load($(next).attr('data-src'));
                    audio.play();
                }
            });

            // Load in the first track
            var audio = a[0];
            audio.load($('ul li a.sm2_button').attr('data-src'));

            // Load in a track on click
            $('ul li a.sm2_button').click(function (e) {
                if ($(this).hasClass('playing')) {
                    $(this).removeClass('sm2_paused').addClass('sm2_play');
                    audio.pause();
                }
                else {
                    $('ul li a.playing').removeClass('playing').addClass('sm2_play').removeClass('sm2_paused');
                    e.preventDefault();
                    $(this).addClass('playing').siblings().removeClass('playing');
                    $(this).addClass('sm2_paused').removeClass('sm2_play');
                    audio.load($(this).attr('data-src'));
                    audio.play();
                }

            });
        });
    </script>
<?php endif; ?>

</body>
</html>