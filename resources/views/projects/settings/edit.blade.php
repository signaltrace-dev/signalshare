@extends('layouts/app')

@section('title')
    Project Settings for <em>{{ $project->name }}</em>
@endsection

@section('content')
<script type="text/javascript">
$(document).ready(function(){
    $( "#modal-delete-project" ).on('shown.bs.modal', function(){

        var v = new Vue({
            el: '#modal-delete-project',
            data:{
                projectname: '',
            }
        });
    });
});


</script>

    <form action='{{ route("projects.settings.update", $project->slug, $settings->id) }}' method="POST">
        {{ method_field('PATCH') }}
        <label for="name">Project Name:</label>
        <input type="text" name="name"  placeholder="Name" value="{{ $project->name }}" />
        <button type="submit" name="button" class="btn btn-success">Save Settings</button>
    </form>
@include('tags.forms.tag_picker', ['project' => $project])
    <button type="button" name="btn-modal" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-project">Delete This Project</button>
    <div class="modal fade" id='modal-delete-project'>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Delete This Project?</h4>
          </div>
          <div class="modal-body">
              <form action='{{ route("projects.destroy", $project->slug) }}' method="POST">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <p>
                      Woah, are you absolutely sure you want to delete this project?
                      This is <em>permanent</em>, and any tracks that aren't being used on other projects will also be deleted!
                      If you're absolutely sure, type the full project name <em>{{ $project->fullPath() }}</em> in the box and click
                      the 'Yes, Delete This Project' button.
                  </p>
                  <input type="text" name="project-name-confirm" value="" v-model="projectname" id="project-name-confirm">
                  <button type="submit" id="btn-project-name-confirm" name="button" class="btn btn-danger" :disabled=" this.projectname != '{{ $project->fullPath() }}' ">Yes, Delete This Project</button>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



@endsection
