$(document).ready(function(){
  var signalshare = {};
  signalshare.tracks = [];

  var togglePlayButton = function(playing){
    $('.btn-play-all').toggleClass('btn-info').toggleClass('btn-danger');
    $('.btn-play-all i').toggleClass('fa-play').toggleClass('fa-pause');

    if(!playing){
      $('.btn-play-all span').text('Stop');
    }
    else{
      $('.btn-play-all span').text('Play All');
    }
  };

  $('.project-track').each(function(){
    var trackElem = this;
      var src = $(this).data('src');
      $.ajax({
          url:src,
          type:'HEAD',
          success: function()
          {
            var wavesurfer = Object.create(WaveSurfer);

            wavesurfer.init({
                container: trackElem,
                waveColor: '#A6C4FF',
                progressColor: '#89B0FF',
            });

            wavesurfer.on('play', function(){
            });

            wavesurfer.load(src);
            $(trackElem).addClass('loaded');
            $(trackElem).parent().find('.btn-play').first().removeClass('hidden');
            signalshare.tracks.push(wavesurfer);

          }
      });
    });
    $('.btn-play-all').on('click', function(){
      var playing = signalshare.tracks[0].isPlaying();

      signalshare.tracks[0].on('finish', function(){
        togglePlayButton(true);
      });

      togglePlayButton(playing);

      $(signalshare.tracks).each(function(){
        if(this.backend.source){
          this.playPause();
        }
      });
    });
});
