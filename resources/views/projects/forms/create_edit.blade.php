<form action='{{ $form_action }}' method="POST">
    {{ method_field($form_method) }}
    {{ csrf_field() }}

    <p class="control has-addons has-addons-centered">
        <label class="sr-only" for="name">Name</label>
        <input class="input {{ $errors->has('name') ? ' is-danger' : '' }}" type="text" name="name"  placeholder="Yakety Sax Volume 2" value="{{ !empty($project) ? $project->name : '' }}" />
        <button type="submit" class="button is-success">{{ $submit_text }}</button>
    </p>
</form>
