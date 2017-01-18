signalsharePlayer = {
    tracks: []
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var togglePlayButton = function(playing) {
        $('.btn-play-all').toggleClass('btn-info').toggleClass('btn-danger');
        $('.btn-play-all i').toggleClass('fa-play').toggleClass('fa-pause');

        if (!playing) {
            $('.btn-play-all span').text('Stop');
        } else {
            $('.btn-play-all span').text('Play All');
        }
    };

    $('.project-track').each(function() {
        var trackElem = this;
        var src = $(this).data('src');
        $.ajax({
            url: src,
            type: 'HEAD',
            success: function() {
                var wavesurfer = Object.create(WaveSurfer);

                wavesurfer.init({
                    container: trackElem,
                    waveColor: '#A6C4FF',
                    progressColor: '#89B0FF',
                });

                wavesurfer.on('play', function() {});

                wavesurfer.load(src);
                $(trackElem).addClass('loaded');
                $(trackElem).parent().find('.btn-play').first().removeClass('hidden');

                signalsharePlayer.tracks.push(wavesurfer);

                $(trackElem).parent().find('.btn-mute').data('track', signalsharePlayer.tracks.length - 1);
                $(trackElem).data('track', signalsharePlayer.tracks.length - 1);
            }
        });
    });
    $('.btn-play-all').on('click', function() {
        var playing = signalsharePlayer.tracks[0].isPlaying();

        signalsharePlayer.tracks[0].on('finish', function() {
            togglePlayButton(true);
        });

        togglePlayButton(playing);

        $(signalsharePlayer.tracks).each(function() {
            if (this.backend.source) {
                this.playPause();
            }
        });
    });

    $('.btn-mute').on('click', function() {
        var trackNum = $(this).data('track');
        var track = trackNum in signalsharePlayer.tracks && signalsharePlayer.tracks[trackNum];
        if (track) {
            track.toggleMute();

            $(this).toggleClass('muted');
            var muted = $(this).hasClass('muted');
            $(this).html(muted ? 'Unmute <i class="fa fa-volume-up"></i>' : 'Mute <i class="fa fa-volume-off"></i>');

            $(this).parent().parent().find('.project-track').toggleClass('muted');
        }
    });
});
