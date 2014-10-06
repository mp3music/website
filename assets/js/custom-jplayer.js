$(document).ready(function(){
    $("#jquery_jplayer").jPlayer({
        swfPath: "/assets/js/Jplayer.swf",
        supplied: "mp3",
        wmode: "window",
        solution: "flash, html"
    });

    $('.jp-play').click(function(e) {
        e.preventDefault();
        if($("#jquery_jplayer").data().jPlayer.status.paused) {
            $("#jquery_jplayer").jPlayer("setMedia", {mp3: this.href }).jPlayer('play');
            $(this).removeClass('jp-play').removeClass('glyphicon-play').addClass('glyphicon-pause').addClass('jp-pause');
        }
       else {
            $('#jquery_jplayer').jPlayer('pause');
            $(this).removeClass('jp-pause').removeClass('glyphicon-pause').addClass('glyphicon-play').addClass('jp-play');
        }
    });
});