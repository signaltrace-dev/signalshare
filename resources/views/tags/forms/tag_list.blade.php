@foreach( $project->tags as $tag )
    <div class="btn btn-info">{{ $tag->name }}
    <form class="form-inline" action='{{ route("tags.detach") }}' method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="tagId" value="{{ $tag->id }}">
        <input type="hidden" name="targetId" value="{{ $project->id }}">
        <input type="hidden" name="targetType" value="project">

        <button type="submit" class="link-delete"><i class="fa fa-times"></i></button></div>
    </form>
@endforeach
