<div id="tagger">
    <script type="text/javascript">
        $(document).ready(function(){
            tagger.getTags('projects', '{{ $project->slug }}' );

            $(tagger.search).on('awesomplete-selectcomplete', function(e, data){
                tagger.attachTag('project', {{ $project->id }}, this.value);
            });
        });
    </script>

    @include('tags.forms.tag_list', ['project' => $project])

    <form action='{{ route("tags.attach") }}' method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="targetid" value="{{ $project->id }}">
        <input type="hidden" name="targettype" value="project">
        <input type="text" name="tagname" value="" id="txt-tag-search">
        <button class="btn btn-success" id="btn-attach-tag" type="submit" name="button">Assign Tag</button>
    </form>
</div>
