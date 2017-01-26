<form action='{{ route("taxonomies.store") }}' method="POST">
    {{ csrf_field() }}
    <input type="text" name="name" value="">
    <button class="btn btn-success" type="submit" name="button">Add Taxonomy</button>
</form>
