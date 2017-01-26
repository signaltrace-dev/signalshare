<?php

namespace App;

class TaggerFactory
{
    public static function create($type)
    {
        switch($type)
        {
            case 'projects':
                return new Project();
                break;
            case 'tags':
                return new Tag();
                break;
            default:
                return NULL;
                break;
        }
    }

    public static function find($type, $id)
    {
        switch($type)
        {
            case 'projects':
                if(is_numeric($id)){
                    return Project::find($id);
                }
                else{
                    return Project::where('slug', $id)->first();
                }
                break;
            case 'tags':
                if(is_numeric($id)){
                    return Tag::find($id);
                }
                else{
                    return Tag::where('slug', $id)->first();
                }
                break;
            default:
                return NULL;
                break;
        }
    }
}
