<script type="text/javascript">
    $(document).ready(function(){
        $('#txt-tag-search').autocomplete({
            serviceUrl: '/tags/search/autocomplete',
            onSelect: function (suggestion) {
                tagger.attachTag('project', {{ $project->id }}, suggestion.data);
            }
        });
    });
</script>

@include('tags.forms.tag_list', ['project' => $project])

<form action='{{ route("tags.autocomplete") }}' method="GET">
    {{ csrf_field() }}
    <input type="text" name="name" value="" id="txt-tag-search">
    <button class="btn btn-success" type="submit" name="button">Search</button>
</form>
