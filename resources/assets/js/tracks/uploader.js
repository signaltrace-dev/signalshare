Dropzone.options.fileupload = {
    acceptedFiles: ".mp3,.wav,.ogg",
    sending: function(file, xhr, formData) {
        $('.dz-message').hide();
        formData.append("_token", $('[name=_token').val());
    },
    queuecomplete: function(event){
        $('.dz-complete').fadeOut(function(){
            $('.dz-message').fadeIn();
        });
    },
    success: function(event, response){
        if(response.status && response.status == 1){
            var project_slug = response.project.slug;
            var track_slug = response.track.slug;
            var file_url = response.file.filename;

            $.ajax({
                url: '/projects/' + project_slug + '/tracks/' + track_slug,
                type:'GET',
                success: function(data){
                    var fileItem = $('<li/>', {'class' : 'track-item added'});

                    $(data).appendTo(fileItem);
                    var src = '/files/' + file_url;
                    $.ajax({
                        url:src,
                        type:'HEAD',
                        success: function()
                        {
                            var trackElem = $(fileItem).find('.project-track').first()[0];

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
                        }
                    });

                    $(fileItem).prependTo('#track-list');
                    setTimeout(function(){
                        $(fileItem).addClass('processed');
                    }, 500);

                    $('.alert-warning').fadeOut();
                    $('.controls').removeClass('hidden');
                }
              });
        }
    },
};

$(document).ready(function(){
    $('#btn-submit').hide();
});
