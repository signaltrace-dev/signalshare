<form action='{{ $form_action }}' method="POST">
    {{ method_field($form_method) }}
    {{ csrf_field() }}
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name"  placeholder="Name" value="{{ !empty($project) ? $project->name : '' }}" />
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $submit_text }}</button>
    </div>
</form>
