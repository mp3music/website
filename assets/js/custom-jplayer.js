$(document).ready(function(){
    $("#jquery_jplayer").jPlayer({
        swfPath: "/assets/js/Jplayer.swf",
        supplied: "mp3",
        wmode: "window",
        solution: "flash, html"
    });

    $('.jp-play').click(function(e) {
        e.preventDefault();
        $("#jquery_jplayer")
            .jPlayer("setMedia", {mp3: this.href }).jPlayer('play')
    });

    $('.jp-pause').click(function() {
        $('#jquery_jplayer').jPlayer('pause');
    });
});