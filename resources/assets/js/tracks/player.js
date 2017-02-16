signalsharePlayer = {
    tracks: [],
    trackLengths: [],
    project: '',
    metronomeOn: false,
    controls: [],
    recorder: null,
}

$(document).ready(function() {
    signalsharePlayer.context = new AudioContext();

    signalsharePlayer.data = new Vue({
        el: '#player',
        data: {
            recording: false,
            tracks: [],
            trackLengths: [],
            tracksPlaying: 0,
            metronomeOn: false,
            time: 0,
        },
        computed: {
            playIconClass: function(){
                var iconClass = 'fa fa-play';
                if(this.playing || this.recording){
                    iconClass = 'fa fa-stop';
                }
                return iconClass;
            },
            recordIconClass: function(){
                var iconClass = 'fa fa-microphone';
                if(this.playing || this.recording){
                    iconClass = 'fa fa-stop';
                }
                return iconClass;
            },
            playing: function(){
                return this.tracksPlaying > 0;
            },
            longestTrack: function(){
                var maxIndex = signalsharePlayer.data.trackLengths.reduce((iMax, x, i, arr) => x > arr[iMax] ? i : iMax, 0);
                return maxIndex;
            },
            timeDisplay: function(){
                var minutes = 0;
                var seconds = Math.round(this.time);

                while(seconds > 60){
                    minutes++;
                    seconds = seconds - 60;
                }

                if(minutes < 10){
                    minutes = "0" + minutes;
                }
                if(seconds < 10){
                    seconds = "0" + seconds;
                }

                return minutes + ":" + seconds;
            }
        }
    });

    signalsharePlayer.controls.record = document.getElementById('btn-record');
    signalsharePlayer.controls.stop = document.getElementById('btn-record-stop');
    signalsharePlayer.controls.alertRecording = document.getElementById('alert-recording');
    signalsharePlayer.controls.playAll = document.getElementById('btn-play-all');

    signalsharePlayer.addTrack = function(trackElem, isNew = false) {
        var src = $(trackElem).data('src');
        $.ajax({
            url: src,
            type: 'HEAD',
            success: function() {
                $('#btn-play-all').removeClass('hidden');
                var wavesurfer = Object.create(WaveSurfer);
                var projectTrack = $(trackElem).find('.project-track').first()[0];
                wavesurfer.init({
                    container: projectTrack,
                    waveColor: '#A6C4FF',
                    progressColor: '#89B0FF',
                    fillParent: false,
                    minPxPerSec: 3,
                });

                wavesurfer.on('play', function() {
                    signalsharePlayer.data.tracksPlaying++;
                });

                wavesurfer.load(src);

                wavesurfer.on('ready', function(){
                    $(wavesurfer.container).addClass('loaded');
                    $(wavesurfer.container).addClass(src);

                    signalsharePlayer.data.tracks.push(wavesurfer);

                    var trackIndex = signalsharePlayer.data.tracks.length - 1;
                    $(trackElem).find('.btn-mute').data('track', trackIndex);
                    $(projectTrack).data('track', trackIndex);
                    signalsharePlayer.data.trackLengths[trackIndex] = wavesurfer.backend.buffer.duration;

                    signalsharePlayer.setButtonHandlers(trackElem);

                    if(trackIndex === signalsharePlayer.data.longestTrack){

                    }
                    wavesurfer.on('audioprocess', function(){
                        if(!signalsharePlayer.data.recording){
                            signalsharePlayer.data.time = wavesurfer.getCurrentTime();
                        }
                    });

                    wavesurfer.on('finish', function() {
                        if(signalsharePlayer.data.tracksPlaying > 0){
                            signalsharePlayer.data.tracksPlaying--;
                        }
                    });

                    wavesurfer.on('pause', function() {
                        if(signalsharePlayer.data.tracksPlaying > 0){
                            signalsharePlayer.data.tracksPlaying--;
                        }
                    });
                });



                if (isNew) {
                    $(trackElem).addClass('added');
                    $(trackElem).appendTo('#track-list');
                    setTimeout(function() {
                        $(trackElem).addClass('processed');
                    }, 500);

                    $('.alert-warning').fadeOut();
                    $('.controls').removeClass('hidden');
                }
            }
        });
    };

    // Process an AJAX response from a file upload and extract track information
    signalsharePlayer.processUpload = function(response){
        var project_slug = response.project.slug;
        var track_slug = response.track.slug;
        var file_url = response.file.filename;

        // Get track content and add to track list
        $.ajax({
            url: '/projects/' + project_slug + '/tracks/' + track_slug,
            type: 'GET',
            success: function(data) {
                var fileItem = $('<div/>').html(data).contents();
                var trackElem = fileItem.first('.track-item');
                $(trackElem).data('src', '/files/' + file_url);
                signalsharePlayer.addTrack(trackElem, true);

                signalsharePlayer.controls.playAll.classList.remove('hidden');

            }
        });
    };

    signalsharePlayer.setButtonHandlers = function(trackElem) {
        $(trackElem).find('.btn-mute').on('click', function() {
            var trackNum = $(this).data('track');
            var track = trackNum in signalsharePlayer.data.tracks && signalsharePlayer.data.tracks[trackNum];
            if (track) {
                track.toggleMute();

                $(this).toggleClass('muted');
                var muted = $(this).hasClass('muted');
                $(this).html(muted ? 'Unmute&nbsp;<i class="fa fa-volume-up"></i>' : 'Mute&nbsp;<i class="fa fa-volume-off"></i>');

                $(trackElem).find('.project-track').toggleClass('muted');
            }
        });
    };

    signalsharePlayer.stopAll = function(){
        if(signalsharePlayer.data.tracks.length > 0){

            $(signalsharePlayer.data.tracks).each(function() {
                if(this.isPlaying()){
                    this.stop();
                }
                this.seekTo(0);
            });

        }
    }

    signalsharePlayer.playAll = function() {
        if(signalsharePlayer.data.tracks.length > 0){

            $(signalsharePlayer.data.tracks).each(function() {
                if (this.backend.source) {
                    this.playPause();
                }
            });
        }
    };

    signalsharePlayer.pauseAll = function() {
        if(signalsharePlayer.data.tracks.length > 0){

            $(signalsharePlayer.data.tracks).each(function() {
                if (this.backend.source && this.isPlaying()) {
                    this.playPause();
                }
            });
        }
    };

    signalsharePlayer.recording = function(isRec){
        signalsharePlayer.data.recording = isRec;
        signalsharePlayer.data.time = 0;

        if(isRec){
            signalsharePlayer.timer = setInterval(function(){
                signalsharePlayer.data.time++;
            }, 1000);
        }
        else{
            clearInterval(signalsharePlayer.timer);
        }
    };

    $('#btn-play-all').on('click', function(){
        signalsharePlayer.playAll();
    });

    $('#btn-pause-all').on('click', function(){
        signalsharePlayer.pauseAll();
    });

    $('#btn-stop-all').on('click', function(){
        signalsharePlayer.stopAll();
    });

    $('#btn-metronome').on('click', function(){
        $(this).toggleClass('btn-success');
        $(this).toggleClass('on');

        $('.metronome').toggleClass('visible');
        signalsharePlayer.metronomeOn = !signalsharePlayer.metronomeOn;
    });

    signalsharePlayer.togglePlayButton = function(isPlaying) {
        if (!isPlaying) {
            $('.btn-play-all').addClass('btn-success').removeClass('btn-danger');
            $('.btn-play-all i').addClass('fa-play').removeClass('fa-pause');
            $('.btn-play-all span').text('Play All');

        } else {
            $('.btn-play-all').removeClass('btn-success').addClass('btn-danger');
            $('.btn-play-all i').removeClass('fa-play').addClass('fa-pause');
            $('.btn-play-all span').text('Stop');

        }
    };

    $('.track-item').each(function() {
        signalsharePlayer.addTrack(this);
    });

});
