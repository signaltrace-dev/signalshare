<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="name"  placeholder="Name" value="{{ $project->name }}" />
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $submit_text }}</button>
</div>
{{ csrf_field() }}
