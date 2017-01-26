<form action='{{ route("taxonomies.tags.store", ['taxonomy' => $taxonomy]) }}' method="POST">
    {{ csrf_field() }}
    <input type="text" name="name" value="">
    <button class="btn btn-success" type="submit" name="button">Add Tag</button>
</form>
