<div class='flash alert-danger {{ $errors->any() ? '' : 'hidden' }}'>
  @foreach ( $errors->all() as $error )
    <p>{{ $error }}</p>
  @endforeach
</div>

<form class='ajax dropzone' action='{{ route("projects.tracks.store", $project->slug) }}' method="POST" enctype="multipart/form-data">
    @include('tracks/partials/_form', ['submit_text' => 'Create Track', 'project' => $project, 'action' => route("projects.tracks.store", $project->slug)])
</form>
