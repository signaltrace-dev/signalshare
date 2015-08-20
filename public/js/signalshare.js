$(document).ready(function(){
  var signalshare = {};
  signalshare.tracks = [];

  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
  });

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

    function submitAjax(url, form){
      $.ajax({
          url:url,
          type:'POST',
          data: {'name':$('input[name=name]').val(), '_token': $('input[name=_token]').val()},
          success: function()
          {

          },
          error: function(res){
            errors = res.responseJSON;
            var listErrors = $('<ul/>', {id: 'errors'});

            $.each(errors, function(key, value){
              $(form).find('input[name="' + key + '"]').addClass('error');
              $('<li/>', {id: 'list-error', text: value[0]}).appendTo(listErrors);

            });

            $(listErrors).appendTo('.flash.alert-danger');
            $('.modal .flash.alert-danger').removeClass('hidden');
          }
        });
    }

    $('#modal-create-track').on('show.bs.modal', function(e){
      var url = $(e.relatedTarget).data('href');
      $.ajax({
        url:url,
        type:'GET',
        success: function(res)
        {
          $('.modal-body').html(res);
        },
      });

    });

    $('#modal-create-track').on('shown.bs.modal', function (e) {
      $('form.ajax').each(function(){
        var form = this;
        var btnSubmit = $(this).find('input[type=submit]').first();
        var formUrl = $(this).attr('action');
        $(btnSubmit).on('click', function(e){
          e.preventDefault();
          submitAjax(formUrl, form);
        });

      });
    });
});
