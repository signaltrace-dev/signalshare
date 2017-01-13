<script type="text/javascript" src="{{ URL::asset('js/vendor/jquery.ui.widget.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/vendor/jquery.iframe-transport.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/vendor/jquery.fileupload.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var url = "{{ route('create_file', $project) }}";
    var audioFile;
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
          if(data.result.files && data.result.files.length > 0){
            $('.progress').addClass('hidden');
            var fileList = $('<ul/>', {class: 'filelist'}).appendTo('#files');

            $.each(data.result.files, function (index, file) {
              var fileItem = $('<li/>');

              $('<span/>', {text:file.name, class: 'filename'}).appendTo(fileItem);
              var btnCancel = $('<i/>', {class: 'fa fa-times btn-icon btn-cancel'}).appendTo(fileItem);

              btnCancel.on('click', function(){
                deleteFile();
              });

              $(fileItem).appendTo(fileList);
              $('#audio-file').val(file.name);
              audioFile = file;
            });

            $(fileList).appendTo('#files');
          }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress').removeClass('hidden');
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    var deleteFile = function(){
      $('.filelist').remove();
      var url = "{{ route('delete_file', $project) }}";
      $.ajax({
          url:url,
          type:'POST',
          data: {'filename':audioFile.name, '_token': $('input[name=_token]').val()},
        });
      audioFile = '';
    };
  });
</script>

{!! Form::hidden('project', $project->id ) !!}

<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name') !!}
</div>

<div class="form-group">
    {!! Form::label('Upload Audio') !!}
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select file</span>
        {!! Form::file('audio', ['id' => 'fileupload']) !!}
        {!! Form::hidden('audiofile', null, ['id' => 'audio-file'] ) !!}

    </span>
    <div id="progress" class="progress hidden">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <div id="files" class="files"></div>
</div>


<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
</div>
