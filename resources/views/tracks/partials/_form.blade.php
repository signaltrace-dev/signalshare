<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name') !!}
</div>

<div class="form-group">
    {!! Form::label('Upload Audio') !!}
    {!! Form::file('audio', null) !!}
</div>


<div class="form-group">
    {!! Form::submit($submit_text, ['class'=>'btn btn-primary']) !!}
</div>
