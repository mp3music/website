<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <meta name="description" content="<?= $description; ?>">
    <style type="text/css">
        html{font-family:"Trebuchet MS",Helvetica,sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-size:10px;-webkit-tap-highlight-color:transparent;color:#5f5f5f}body{margin:0;font-size:14px;line-height:1.42857143;background-color:#fff}a{background-color:transparent;color:#337ab7;text-decoration:none}strong{font-weight:700}h1{margin:.67em 0;font-family:inherit;font-weight:500;line-height:1.1;color:inherit;margin-top:20px;margin-bottom:10px;font-size:36px}button,input{color:inherit;font:inherit;margin:0;line-height:inherit}button{overflow:visible;text-transform:none;-webkit-appearance:button;cursor:pointer}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}@media print{*,:after,:before{background:0 0!important;color:#000!important;-webkit-box-shadow:none!important;box-shadow:none!important;text-shadow:none!important}a{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}p{orphans:3;widows:3}.navbar{display:none}.label{border:1px solid #000}}*,:after,:before{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}p{margin:0 0 10px}ul{margin-top:0;margin-bottom:10px}.list-inline{padding-left:0;list-style:none;margin-left:-5px}.list-inline > li{display:inline-block;padding-left:5px;padding-right:5px}.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}@media (min-width: 768px){.container{width:750px}}@media (min-width: 992px){.container{width:970px}}@media (min-width: 1200px){.container{width:1170px}}.row{margin-left:-15px;margin-right:-15px}.col-sm-4,.col-sm-8,.col-xs-12{position:relative;min-height:1px;padding-left:15px;padding-right:15px}.col-xs-12{float:left;width:100%}@media (min-width: 768px){.col-sm-4,.col-sm-8{float:left}.col-sm-8{width:66.66666667%}.col-sm-4{width:33.33333333%}}.form-control{display:block;width:100%;height:34px;padding:6px 12px;font-size:14px;line-height:1.42857143;color:#555;background-color:#fff;background-image:none;border:1px solid #ccc;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s}.form-control::-moz-placeholder{color:#999;opacity:1}.form-control:-ms-input-placeholder{color:#999}.form-control::-webkit-input-placeholder{color:#999}.btn{display:inline-block;margin-bottom:0;font-weight:400;text-align:center;vertical-align:middle;-ms-touch-action:manipulation;touch-action:manipulation;cursor:pointer;background-image:none;border:1px solid transparent;white-space:nowrap;padding:6px 12px;font-size:14px;line-height:1.42857143;border-radius:4px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.btn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da}.input-group{position:relative;display:table;border-collapse:separate}.input-group .form-control{position:relative;z-index:2;float:left;width:100%;margin-bottom:0}.input-group .form-control,.input-group-btn{display:table-cell}.input-group-btn{width:1%;vertical-align:middle}.input-group .form-control:first-child{border-bottom-right-radius:0;border-top-right-radius:0}.input-group-btn:last-child > .btn{border-bottom-left-radius:0;border-top-left-radius:0}.input-group-btn{position:relative;font-size:0;white-space:nowrap}.input-group-btn > .btn{position:relative}.input-group-btn:last-child > .btn{margin-left:-1px}.navbar{position:relative;min-height:50px;margin-bottom:20px;border:1px solid transparent}@media (min-width: 768px){.navbar{border-radius:4px}}.navbar-fixed-top{position:fixed;right:0;left:0;z-index:1030;top:0;border-width:0 0 1px}@media (min-width: 768px){.navbar-fixed-top{border-radius:0}}.navbar-brand{float:left;padding:15px;font-size:18px;line-height:20px;height:50px}@media (min-width: 768px){.navbar > .container .navbar-brand{margin-left:-15px}}.navbar-default{background-color:#f8f8f8;border-color:#e7e7e7}.navbar-default .navbar-brand{color:#777}.label{display:inline;padding:.2em .6em .3em;font-size:75%;font-weight:700;line-height:1;color:#fff;text-align:center;white-space:nowrap;vertical-align:baseline;border-radius:.25em}.label-info{background-color:#5bc0de}.list-group{margin-bottom:20px;padding-left:0}.list-group-item{position:relative;display:block;padding:5px 15px;margin-bottom:-1px;background-color:#fff;border:1px solid #ddd}.list-group-item:first-child{border-top-right-radius:4px;border-top-left-radius:4px}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-right-radius:3px;border-top-left-radius:3px}.panel-title{margin-top:0;margin-bottom:0;font-size:16px;color:inherit}.panel > .list-group{margin-bottom:0}.panel > .list-group .list-group-item{border-width:1px 0;border-radius:0}.panel-heading + .list-group .list-group-item:first-child{border-top-width:0}.panel-default{border-color:#ddd}.panel-default > .panel-heading{color:#333;background-color:#f5f5f5;border-color:#ddd}.container:after,.container:before,.navbar:after,.navbar:before,.row:after,.row:before{content:" ";display:table}.container:after,.navbar:after,.row:after{clear:both}body{color:#5f5f5f;font-family:"Trebuchet MS",Helvetica,sans-serif;padding-top:70px}.logo-block{color:#5f5f5f;font-style:italic;font-weight:700;font-size:130%;text-align:center}.container-custom{padding-bottom:12px}.search-bar-custom{height:50px}.search-input{margin-top:8px}@media (min-width: 1200px){.blog-main{padding-right:inherit}}.blog-post .panel-title{font-weight:700;text-align:center;font-size:110%;color:#5f5f5f}.list-group-item-custom{padding:5px 15px}.list-group-item-custom .list-group-href{font-size:14px;display:block}.sidebar-module{border:1px solid silver;border-top:3px solid silver;padding:10px 19px;border-radius:4px}.sidebar-module.sidebar-now-playing{margin-top:20px}.sidebar-module .label-info-custom{font-size:100%;line-height:3;font-weight:900}.artist_name{color:#3F4447}.track_title{font-size:120%}.jp-type-single{float:right;position:relative;top:-14px}.jp-controls.bs-glyphicons-list{list-style:none;text-align:center}.download-button{position:relative;display:inline-block;width:30px;height:30px;text-indent:-9999px;overflow:hidden;vertical-align:middle;border-radius:2px;margin-top:-1px;-webkit-transition-property:hover;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out 0;-o-transition-property:background-color;-o-transition-duration:.15s;*text-indent:0;*line-height:99em;*vertical-align:top;background-color:#6195af;background-image:url(/assets/images/download.png);background-repeat:no-repeat;background-position:11px 50%}.duration{color:#999;font-size:13px}a.sm2_button{position:relative;display:inline-block;width:30px;height:30px;text-indent:-9999px;overflow:hidden;vertical-align:middle;border-radius:2px;margin-top:-1px;/-webkit-transition-property:hover;-webkit-transition:all .2s ease-in-out;-moz-transition:all .2s ease-in-out 0;-o-transition-property:background-color;-o-transition-duration:.15s}a.sm2_button:focus{outline:none}a.sm2_play,a.sm2_button.sm2_paused:hover{background-color:#39c;background-image:url(/assets/images/arrow-right-white.png);background-size:9px 10px;background-repeat:no-repeat;background-position:10px 50%}a.sm2_paused{background-color:#c33;background-image:url(/assets/images/pause.png);background-size:9px 10px;background-repeat:no-repeat;background-position:10px 50%}a.sm2_button:hover,a.sm2_button.sm2_play:hover{background-color:#c33}.audiojs{width:100%;height:30px;background:#404040;position:fixed;bottom:0;font-family:inherit;font-size:12px;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#444),color-stop(0.5,#555),color-stop(0.51,#444),color-stop(1,#444));background-image:-moz-linear-gradient(center top,#444 0%,#555 50%,#444 51%,#444 100%);-webkit-box-shadow:1px 1px 8px rgba(0,0,0,0.3);-moz-box-shadow:1px 1px 8px rgba(0,0,0,0.3);-o-box-shadow:1px 1px 8px rgba(0,0,0,0.3);box-shadow:1px 1px 8px rgba(0,0,0,0.3)}.audiojs .play-pause{width:8%;height:40px;padding:2px 6px;margin:0;float:left;overflow:hidden;border-right:1px solid #3D3D3D}.audiojs .scrubber{position:relative;float:left;width:85%;background:#5a5a5a;height:10px;margin:10px;border-top:1px solid #3f3f3f;border-left:0;border-bottom:0;overflow:hidden}.audiojs .time{display:none;float:left;height:30px;line-height:30px;margin:0 0 0 6px;padding:0 6px 0 12px;border-left:1px solid #3D3D3D;color:#ddd;text-shadow:1px 1px 0 rgba(0,0,0,0.5)}.audiojs .loaded{position:absolute;top:0;left:0;height:10px;width:0;border-radius:1px;background:#000;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#222),color-stop(0.5,#333),color-stop(0.51,#222),color-stop(1,#222));background-image:-moz-linear-gradient(center top,#222 0%,#333 50%,#222 51%,#222 100%)}.audiojs .progress{position:absolute;top:0;left:0;height:10px;width:0;background:#ccc;z-index:1;border-radius:1px;background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,#ccc),color-stop(0.5,#ddd),color-stop(0.51,#ccc),color-stop(1,#ccc));background-image:-moz-linear-gradient(center top,#ccc 0%,#ddd 50%,#ccc 51%,#ccc 100%)}
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
                <p>mp3cooll.com is an easy way to listen music, watch video and download mp3.
                    You can find your favorite songs in our multimillion database of
                    quality mp3 links. Download <?= (isset($query)) ? $query . ' ' : ''; ?>free mp3 songs on your
                    android or iPhone devices. We provide fast and
                    relevant search.
                    Hope you enjoy staying here!</p>

                <div id="fb-root"></div>
                <div class="fb-like" data-href="https://www.facebook.com/pages/Mp3Cooll/342836852560201"
                     data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
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
    var player = <?= isset($query) ? 'true' : 'false'; ?>;
</script>
<script>
    var boostrap = document.createElement('link');
    boostrap.setAttribute('href', '/assets/css/bootstrap.min.css');
    boostrap.setAttribute('rel', 'stylesheet');
    document.getElementsByTagName('head')[0].appendChild(boostrap);

    var script = document.createElement('script');
    script.setAttribute('src', '/assets/js/main.js');
    if(player) {
        script.onload = function() {
            var script = document.createElement('script');
            script.setAttribute('src', '/assets/js/audio.min.js');
            document.getElementsByTagName('head')[0].appendChild(script);
        };
    }

    document.getElementsByTagName('head')[0].appendChild(script);
</script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
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

    window.onload = function () {
        var js, fjs = document.getElementsByTagName('script')[0];
        if (document.getElementById('facebook-jssdk')) return;
        js = document.createElement('script');
        js.async = true;
        js.id = 'facebook-jssdk';
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&appId=368859276603169&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    };
</script>
<audio preload></audio>
</body>
</html>