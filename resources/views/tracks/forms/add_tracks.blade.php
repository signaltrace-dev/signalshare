<script type="text/javascript">
    Dropzone.options.fileupload.url = "{{ route("projects.tracks.store", $project->slug) }}";
</script>
<form action='{{ route("projects.tracks.store", $project->slug) }}' method="POST" enctype="multipart/form-data">

    {{ csrf_field() }}

    <div id="fileupload" class="dropzone">
        <div class="dz-message" data-dz-message><span>Drag files here or click to open a file browser</span></div>
        <div class="fallback">
            <div class="form-group">
                <label for="file">Upload File</label>
                <input name="file" type="file" multiple />
            </div>
            <div class="form-group">
                <button id="btn-submit" type="submit" class="btn btn-primary">Add to Project</button>
            </div>
        </div>
    </div>

    <input type="hidden" name="ajaxfile" id="ajaxfile"/>


</form>
