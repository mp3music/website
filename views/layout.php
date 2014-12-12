<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <meta name="description" content="<?= $description; ?>">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body{color:#5f5f5f;font-family:"Trebuchet MS",Helvetica,sans-serif;padding-top:70px}.logo-block,.logo-block:hover{color:#5f5f5f;font-style:italic;font-weight:700;font-size:130%;text-align:center}.container-custom{padding-bottom:12px}.search-bar-custom{height:50px}.search-input{margin-top:8px}.input-text{width:inherit!important}@media (min-width: 1200px){.blog-main{padding-right:inherit}}.blog-post .panel-title{font-weight:700;text-align:center;font-size:110%;color:#5f5f5f}.blog-post .panel-body-custom{padding:0}.list-group-item-custom{padding:5px 15px}.list-group-item-custom .artist{font-size:14px;color:#428BCA;width:85%}.list-group-item-custom .list-group-href{font-size:14px;display:block}.list-group-item-custom:hover{background-color:#f9f9f9}.list-group-item.list-group-item-custom > span{font-size:12px}.sidebar-module{border:1px solid silver;border-top:3px solid silver;padding:10px 19px;border-radius:4px}.sidebar-module.sidebar-social,.sidebar-module.sidebar-now-playing{margin-top:20px}.sidebar-module .label-info-custom{font-size:100%;line-height:3;font-weight:900}.list-group-item.glyphicon.glyphicon-music.glyphicon-blue{color:#357EBD}.list-group-item.glyphicon.glyphicon-music.glyphicon-blue > span{color:#3c4bf0}.jp-type-single{float:right;position:relative;top:-14px}.jp-controls.bs-glyphicons-list{list-style:none;text-align:center}.download-button{position:relative;display:inline-block;width:30px;height:30px;text-indent:-9999px;overflow:hidden;vertical-align:middle;border-radius:2px;margin-top:-1px;-webkit-transition-property:hover;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out 0;-o-transition-property:background-color;-o-transition-duration:.15s;*text-indent:0;*line-height:99em;*vertical-align:top;background-color:#6195af;background-image:url(/assets/images/download.png);background-repeat:no-repeat;background-position:11px 50%}.artist_name{color:#3F4447}.track_title{font-size:115%}.duration{color:#999;font-size:13px}a.sm2_button{position:relative;display:inline-block;width:30px;height:30px;text-indent:-9999px;overflow:hidden;vertical-align:middle;border-radius:2px;margin-top:-1px;/-webkit-transition-property:hover;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out 0;-o-transition-property:background-color;-o-transition-duration:.15s}a.sm2_button:focus{outline:none}a.sm2_play,a.sm2_button.sm2_paused:hover{background-color:#39c;background-image:url(/assets/images/arrow-right-white.png);background-size:9px 10px;background-repeat:no-repeat;background-position:10px 50%}a.sm2_paused{background-color:#c33;background-image:url(/assets/images/pause.png);background-size:9px 10px;background-repeat:no-repeat;background-position:10px 50%}a.sm2_button:hover,a.sm2_button.sm2_play:hover{background-color:#c33}.audiojs{width:100%;height:30px;background:#404040;position:fixed;bottom:0;font-family:inherit;font-size:12px;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#444),color-stop(0.5,#555),color-stop(0.51,#444),color-stop(1,#444));background-image:-moz-linear-gradient(center top,#444 0%,#555 50%,#444 51%,#444 100%);-webkit-box-shadow:1px 1px 8px rgba(0,0,0,0.3);-moz-box-shadow:1px 1px 8px rgba(0,0,0,0.3);-o-box-shadow:1px 1px 8px rgba(0,0,0,0.3);box-shadow:1px 1px 8px rgba(0,0,0,0.3)}.audiojs .play-pause{width:8%;height:40px;padding:2px 6px;margin:0;float:left;overflow:hidden;border-right:1px solid #3D3D3D}.audiojs .scrubber{position:relative;float:left;width:85%;background:#5a5a5a;height:10px;margin:10px;border-top:1px solid #3f3f3f;border-left:0;border-bottom:0;overflow:hidden}.audiojs .time{display:none;float:left;height:30px;line-height:30px;margin:0 0 0 6px;padding:0 6px 0 12px;border-left:1px solid #3D3D3D;color:#ddd;text-shadow:1px 1px 0 rgba(0,0,0,0.5)}.audiojs .loaded{position:absolute;top:0;left:0;height:10px;width:0;border-radius:1px;background:#000;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#222),color-stop(0.5,#333),color-stop(0.51,#222),color-stop(1,#222));background-image:-moz-linear-gradient(center top,#222 0%,#333 50%,#222 51%,#222 100%)}.audiojs .progress{position:absolute;top:0;left:0;height:10px;width:0;background:#ccc;z-index:1;border-radius:1px;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#ccc),color-stop(0.5,#ddd),color-stop(0.51,#ccc),color-stop(1,#ccc));background-image:-moz-linear-gradient(center top,#ccc 0%,#ddd 50%,#ccc 51%,#ccc 100%)}
    </style>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top search-bar-custom" role="navigation">
    <div class="container container-custom">
        <a href="/" class="logo-block navbar-brand">
            <span class="logo" title="Free mp3 download">MP3Cooll</span>
        </a>

        <form id="search_form" action="/search">
            <div class="input-group search-input">
                <input id="e22" name="q" type="text" class="form-control" placeholder="Type in a song title or artist name" value="<?= isset($query) ? $query : ''; ?>">
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
                    quality mp3 links. Download <?= (isset($query)) ? $query . ' ' : ''; ?>free mp3 songs on your android or iPhone devices. We provide fast and
                    relevant search.
                    Hope you enjoy staying here!
                </p>

                <div id="fb-root"></div>
                <div class="fb-like" data-href="https://www.facebook.com/pages/Mp3Cooll/342836852560201" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                <a href="https://www.facebook.com/mp3coollmusic" target="_blank">Mp3Cooll Facebook Page</a>
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
                    <?php $artists = getLastQueries(25); ?>
                    <?php foreach ($artists as $artist) : ?>
                        <li>
                            <a href="/<?= urlclean($artist, '-'); ?>.html"><?= $artist; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div><a href="/now.html">more</a></div>
            </div>

            <div class="sidebar-module sidebar-now-playing">
                <p>
                    <a href="/disclamer.html">Disclamer</a>
                </p>
            </div>
        </div>
    </div>
</div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    $( document ).ready(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.async = true;
        js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=368859276603169&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(".btn-info").click(function () {
        ga('send', 'event', 'button', 'search');
    });
</script>

<?php if (isset($query)) : ?>
    <audio preload></audio>
    <script src="/assets/js/audiojs/audio.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function () {
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

        $(".inline-playable").click(function () {
            ga('send', 'event', 'button', 'play');
        });
        $(".download-button").click(function () {
            ga('send', 'event', 'button', 'download');
        });
    </script>
<?php endif; ?>
</body>
</html>