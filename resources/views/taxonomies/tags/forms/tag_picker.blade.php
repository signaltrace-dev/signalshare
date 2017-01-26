<script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>
<div id="tagger">
    <tagger targetid='{{ $project->id }}' targetname='{{ $project->slug }}' targettype="projects"></tagger>
</div>
