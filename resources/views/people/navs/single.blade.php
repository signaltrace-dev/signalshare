@if($can_edit)
    <li role="presentation" class="{{ strpos(Route::currentRouteName(), 'people.show') === 0 ? 'active' : '' }}"><a href='{{ route("people.show", ['user' => $people_user]) }}'>View</a></li>
    <li role="presentation" class="{{ strpos(Route::currentRouteName(), 'people.edit') === 0 ? 'active' : '' }}"><a href='{{ route("people.edit", ['user' => $people_user]) }}'>Edit</a></li>
@endif
