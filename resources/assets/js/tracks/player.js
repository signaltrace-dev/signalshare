signalsharePlayer = {
    tracks: []
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    signalsharePlayer.addTrack = function(trackElem, isNew = false) {
        var src = $(trackElem).data('src');
        $.ajax({
            url: src,
            type: 'HEAD',
            success: function() {
                var wavesurfer = Object.create(WaveSurfer);
                var projectTrack = $(trackElem).find('.project-track').first()[0];
                wavesurfer.init({
                    container: projectTrack,
                    waveColor: '#A6C4FF',
                    progressColor: '#89B0FF',
                });

                wavesurfer.on('play', function() {});

                wavesurfer.load(src);
                $(projectTrack).addClass('loaded');

                signalsharePlayer.tracks.push(wavesurfer);

                $(trackElem).find('.btn-mute').data('track', signalsharePlayer.tracks.length - 1);
                $(projectTrack).data('track', signalsharePlayer.tracks.length - 1);

                if (isNew) {
                    $(trackElem).addClass('added');
                    $(trackElem).prependTo('#track-list');
                    setTimeout(function() {
                        $(trackElem).addClass('processed');
                    }, 500);

                    $('.alert-warning').fadeOut();
                    $('.controls').removeClass('hidden');
                }

                signalsharePlayer.setButtonHandlers(trackElem);
            }
        });
    };

    signalsharePlayer.setButtonHandlers = function(trackElem) {
        $(trackElem).find('.btn-mute').on('click', function() {
            var trackNum = $(this).data('track');
            var track = trackNum in signalsharePlayer.tracks && signalsharePlayer.tracks[trackNum];
            if (track) {
                track.toggleMute();

                $(this).toggleClass('muted');
                var muted = $(this).hasClass('muted');
                $(this).html(muted ? 'Unmute <i class="fa fa-volume-up"></i>' : 'Mute <i class="fa fa-volume-off"></i>');

                $(trackElem).find('.project-track').toggleClass('muted');
            }
        });
    };

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

    var togglePlayButton = function(playing) {
        $('.btn-play-all').toggleClass('btn-info').toggleClass('btn-danger');
        $('.btn-play-all i').toggleClass('fa-play').toggleClass('fa-pause');

        if (!playing) {
            $('.btn-play-all span').text('Stop');
        } else {
            $('.btn-play-all span').text('Play');
        }
    };

    $('.track-item').each(function() {
        signalsharePlayer.addTrack(this);
    });

});
