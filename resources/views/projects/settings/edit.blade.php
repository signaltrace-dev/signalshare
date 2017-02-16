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
                var v = new Vue({
                    el: '#pnl-delete-project',
                    data:{
                        projectname: '',
                        showConfirm: false,
                    }
                });
            });


            </script>

            <form action='{{ route("projects.settings.update", ['user' => $project->owner, 'project' => $project->slug]) }}' method="POST" class="form-inline">
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
            <div id="pnl-delete-project" v-cloak>
                <button type="button" name="btn-modal" v-show="!showConfirm" class="button is-danger" @click="showConfirm = true;">Delete This Project</button>
                <div class="box" v-show="showConfirm">
                    <form action='{{ route("projects.destroy", ['project' => $project, 'user' => $user]) }}' method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <p>
                            Woah, are you absolutely sure you want to delete this project?
                            This is <em>permanent</em>, and any tracks that aren't being used on other projects will also be deleted!
                            If you're absolutely sure, type the full project name <em>{{ $project->fullPath() }}</em> in the box and click
                            the 'Yes, Delete This Project' button.
                        </p>
                        <p class="control is-grouped">
                            <input type="text" class="input" name="project-name-confirm" value="" v-model="projectname" id="project-name-confirm">
                            <button type="submit" id="btn-project-name-confirm" name="button" class="button is-danger" :disabled=" this.projectname != '{{ $project->fullPath() }}' ">Yes, Delete This Project</button>
                            <a class="button is-primary" @click="showConfirm = false;">No, I Changed My Mind</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
