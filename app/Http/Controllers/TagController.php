<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Taxonomy;
use Redirect;
use DB;
use Response;
use App\Project;
use App\TaggerFactory;

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
            $taxonomy = Taxonomy::where('id', $tag->taxonomy_id)->first();

            // Remove tag from any associated projects
            $projects = $tag->projects()->get();
            foreach($projects as $project)
            {
                $project->tags()->detach($tag->id);
            }

            $tag->delete();

            return Redirect::route('taxonomies.tags.index', ['taxonomy' => $taxonomy])->with('message', 'Deleted tag ' . $tag->name . '.');
        }
    }

    public function attach(Request $request){
        $tag_id = $request->input('id');
        $tag_name = $request->input('name');
        $target_id = $request->input('targetid');
        $target_type = $request->input('targettype');
        $project = '';

        $tag = !empty($tag_id) ? Tag::find($tag_id) : Tag::where('name', $tag_name)->first();
        if(empty($tag)){
            $tag = new Tag();
            $tag->name = $tag_name;
            $tag->user_id = $request->user()->id;
            $tag->save();
        }

        //TODO: Validate request, make sure user has appropriate access
        $target_obj = TaggerFactory::find($target_type, $target_id);

        if($target_obj != NULL && method_exists($target_obj, 'tags')){
            // Only attach a tag if it's not already attached to the project
            if($target_obj->tags()->where('tags.id', $tag->id)->count() == 0){
                $target_obj->tags()->attach($tag->id, [
                    'user_id' => $request->user()->id,
                ]);
            }

            $response['status'] = 1;
            $response['attached'] = $target_obj->tags()->get();
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

        $tag_id = $request->input('id');
        $tag = Tag::find($tag_id);

        $target_id = $request->input('targetid');
        $target_type = $request->input('targettype');

        $target_obj = TaggerFactory::find($target_type, $target_id);

        if($target_obj != NULL && method_exists($target_obj, 'tags')){
            $target_obj->tags()->detach($tag_id);

            $response['status'] = 1;
            $response['attached'] = $target_obj->tags()->get();
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
