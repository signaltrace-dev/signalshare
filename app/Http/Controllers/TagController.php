<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Taxonomy;
use Redirect;
use DB;
use Response;
use App\Project;

class TagController extends Controller
{
    public function index(Taxonomy $taxonomy)
    {
        $tags = $taxonomy->tags()->get();

        return view('taxonomies.tags.index', compact('tags', 'taxonomy'));
    }

    public function create()
    {
        $taxonomies = Taxonomy::all();
        return view('tags.create', compact('taxonomies'));
    }

    public function store(Request $request, Taxonomy $taxonomy)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags|max:255',
        ]);

        $tag = new Tag;
        $tag->name = $request->input('name');
        $tag->user_id = $request->user()->id;
        $tag->taxonomy_id = $taxonomy->id;
        $tag->save();

        return Redirect::route('taxonomies.tags.index', ['taxonomy' => $taxonomy])->with('message', 'Created new tag ' . $tag->name . '!');
    }

    public function destroy(Request $request, Tag $tag)
    {
        // TODO: Role-based access
        if ($request->user()->id == 1) {
            $taxonomy = Tag::where('id', $tag->taxonomy_id)->get();
            $tag->delete();

            return Redirect::route('taxonomies.tags.index', ['taxonomy' => $taxonomy])->with('message', 'Deleted tag ' . $tag->name . '.');
        }
    }

    public function attach(Request $request){
        $tagId = $request->input('tagid');
        $tagName = $request->input('tagname');
        $targetId = $request->input('targetid');
        $targetType = $request->input('targettype');
        $project = '';

        $tag = !empty($tagId) ? Tag::find($tagId) : Tag::where('name', $tagName)->first();
        if(empty($tag)){
            $tag = new Tag();
            $tag->name = $tagName;
            $tag->user_id = $request->user()->id;
            $tag->save();
        }

        //TODO: Validate request, make sure user has appropriate access
        if($targetType == 'projects'){
            $project = Project::find($targetId);

            // Only attach a tag if it's not already attached to the project
            if($project->tags()->where('tags.id', $tag->id)->count() == 0){
                $project->tags()->attach($tag->id, [
                    'user_id' => $request->user()->id,
                ]);
            }

            $response['status'] = 1;
            $response['tags'] = $project->tags()->get();
        }
        if($request->ajax()){
            return Response::json($response);
        }

        return Redirect::back()->with('message', 'Added tag ' . $tag->name . '.');
    }

    public function detach(Request $request){
        $response = array(
            'status' => 0,
        );

        $tagId = $request->input('tagId');
        $tag = Tag::find($tagId);

        $targetId = $request->input('targetId');
        $targetType = $request->input('targetType');
        $project = '';

        //TODO: Validate request, make sure user has appropriate access
        if($targetType == 'projects'){
            $project = Project::find($targetId);
            $project->tags()->detach($tagId);

            $response['status'] = 1;
            $response['tags'] = $project->tags()->get();
        }


        if($request->ajax()){
            return Response::json($response);
        }

        return Redirect::back()->with('message', 'Removed tag ' . $tag->name . '.');

    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('query');

        $results = array();

        $queries = DB::table('tags')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->limit(5)->get();

        foreach ($queries as $query) {
            $results[] = [ 'value' => $query->id, 'name' => $query->name ];
        }
        return Response::json($results);
    }
}
