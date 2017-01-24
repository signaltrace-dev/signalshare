@foreach( $project->tags as $tag )
    <span class="tag label label-primary">{{ $tag->name }}</span>
@endforeach
