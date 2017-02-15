@extends('layouts/app')

@section('title')
    {{ $project->name }} - Settings
@endsection

@section('pagenav')
    @include('projects.navs.singleproject', ['project' => $project])
@endsection

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
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

            <form action='{{ route("projects.settings.update", ['user' => $user, 'project' => $project->slug]) }}' method="POST" class="form-inline">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="control">
                    <label for="name" class="label">Project Name:</label>
                    <p class="control">
                        <input class="input" type="text" name="name"  placeholder="Name" value="{{ $project->name }}" />
                        @if ($errors->has('name'))
                            <span class="help is-danger">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </p>
                </div>

                <div class="control">
                    <label for="description" class="label">Description:</label>
                    <p class="control">
                        <textarea id="description" class="textarea is-fullwidth" name="description" placeholder="This is the story all about how my life got flipped, turned upside down">{{ old('description', $project->description) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help is-danger">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </p>
                </div>

                <div class="control is-grouped">
                    <p class="control">
                        <button type="submit" class="button is-primary">Save</button>
                    </p>
                </div>

            </form>
            <div class="box">
                <button type="button" name="btn-modal" class="button is-danger" data-toggle="modal" data-target="#modal-delete-project">Delete This Project</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id='modal-delete-project'>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Delete This Project?</h4>
          </div>
          <div class="modal-body">
              <form action='{{ route("projects.destroy", ['project' => $project, 'user' => $user]) }}' method="POST">
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
