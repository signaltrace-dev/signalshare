<form action='{{ $form_action }}' method="POST" class="form-inline">
    {{ method_field($form_method) }}
    {{ csrf_field() }}
    <div class="form-group">
        <label class="sr-only" for="name">Name:</label>
        <input type="text" name="name"  placeholder="Yakety Sax Volume 2" value="{{ !empty($project) ? $project->name : '' }}" />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $submit_text }}</button>
    </div>
</form>
