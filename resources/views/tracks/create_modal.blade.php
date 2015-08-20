<div class='flash alert-danger {{ $errors->any() ? '' : 'hidden' }}'>
  @foreach ( $errors->all() as $error )
    <p>{{ $error }}</p>
  @endforeach
</div>

{!! Form::model(new App\Track, ['route' => ['projects.tracks.store', $project->slug], 'class'=> 'ajax', 'files'=>true]) !!}
    @include('tracks/partials/_form', ['submit_text' => 'Create Track', 'project' => $project])
{!! Form::close() !!}
