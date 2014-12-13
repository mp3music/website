$(document).ready(function () {
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