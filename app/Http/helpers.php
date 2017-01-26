<?php

function GenerateUniqueSlug($object, $name)
{
    $slug = str_slug($name, '-');
    $new_slug = $slug;

    $class_name = get_class($object);
    $exists = $class_name::where(['slug' => $slug])->count();

    $append = 1;
    while($exists){
        $new_slug = $slug . '-' . $append;
        $append++;
        $exists = $class_name::where(['slug' => $new_slug])->count();
    }

    return $new_slug;
}
