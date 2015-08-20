<script type="text/javascript" src="{{ URL::asset('js/vendor/jquery.ui.widget.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/vendor/jquery.iframe-transport.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/vendor/jquery.fileupload.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var url = "{{ route('create_file', $project) }}";
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
                $('#audio-file').val(file.name);
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <div id="files" class="files"></div>
</div>


<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
</div>
