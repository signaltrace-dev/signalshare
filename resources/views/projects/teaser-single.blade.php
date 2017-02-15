<article class="media project">
    <div class="media-content">
        <div class="content">
            <p>
                <a href="{{ route('projects.show', ['slug' => $project->slug, 'username' => $project->owner->name]) }}">
                    <strong class="subtitle">{{ $project->name }}</strong>
                <a/>
                <small><a href="{{ route('people.show', ['user' => $project->owner]) }}">{{ '@' . $project->owner->name }}</a></small>
                <br>
                {{ $project->description }}
            </p>
        </div>
        <nav class="level">
          <div class="level-left">
            <a class="level-item">
              <span class="icon is-small"><i class="fa fa-reply"></i></span>
            </a>
            <a class="level-item">
              <span class="icon is-small"><i class="fa fa-retweet"></i></span>
            </a>
            <a class="level-item">
              <span class="icon is-small"><i class="fa fa-heart"></i></span>
            </a>
          </div>
        </nav>
    </div>

    <div class="media-right">
        @if ($project->collaborators()->count() > 0)
            <span class="tag is-success">{{ $project->collaborators()->count() }} {{ $project->collaborators()->count() > 1 ? 'collaborators' : 'collaborator' }} </span>
        @else
            <span class="tag is-danger">0 collaborators</span>
        @endif

        @if ($project->totalTracks() > 0)
            <span class="tag is-success">{{ $project->totalTracks() }} {{ $project->totalTracks() > 1 ? 'tracks' : 'track' }} </span>
        @else
            <span class="tag is-danger">0 tracks</span>
        @endif
    </div>
</article>
