$(document).ready(function() {
    var mediaPlayer = jQuery('.jpId');
    mediaPlayer.jPlayer({
        swfPath: '/asset/Jplayer.swf',
        solution:    "flash, html",
        supplied : 'mp3, oga, wav',
        cssSelector: {
            play: '.jp-play',
            pause: '.jp-pause'
        },
        ready: function() {jQuery(this).jPlayer("setMedia", {
            mp3: '/mp3/burito_feat_yolka_-_ty_znaesh_(zaycev.net).mp3',
            oga: '/audio/track.oga',
            wav: '/audio/track.wav'
        });}

    });
    $('.jp-play').click(function() {
        $('.jpId').jPlayer('play');
    });
    $('.jp-pause').click(function() {
        $('.jpId').jPlayer('pause');
    });
});