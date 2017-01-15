<script type="text/javascript" src="{{ URL::asset('js/vendor/dropzone.js') }}"></script>

<script type="text/javascript">
    Dropzone.options.fileupload = {
        url: "{{ route("projects.tracks.store", $project->slug) }}",
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
                            var trackElem = $(fileItem).find('.project-track').first()[0];
                            var src = '/files/' + file_url;
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
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    });
</script>
<form action='{{ route("projects.tracks.store", $project->slug) }}' method="POST" enctype="multipart/form-data">

    {{ csrf_field() }}

    <div id="fileupload" class="dropzone">
        <div class="dz-message" data-dz-message><span>Drag files here or click to open a file browser</span></div>
        <div class="fallback">
            <div class="form-group">
                <label for="file">Upload File</label>
                <input name="file" type="file" multiple />
            </div>
            <div class="form-group">
                <button id="btn-submit" type="submit" class="btn btn-primary">Add to Project</button>
            </div>
        </div>
    </div>

    <input type="hidden" name="ajaxfile" id="ajaxfile"/>


</form>
