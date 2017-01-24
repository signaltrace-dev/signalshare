<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Redirect;
use DB;
use Response;
use App\Project;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags|max:255',
        ]);

        $tag = new Tag;
        $tag->name = $request->input('name');
        $tag->user_id = $request->user()->id;
        $tag->save();

        return Redirect::route('tags.index')->with('message', 'Created new tag ' . $tag->name . '!');
    }

    public function destroy(Request $request, Tag $tag)
    {
        // TODO: Role-based access
        if ($request->user()->id == 1) {
            $tag->delete();

            return Redirect::route('tags.index')->with('message', 'Deleted tag ' . $tag->name . '.');
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
            $project->tags()->attach($tag->id, [
                'user_id' => $request->user()->id,
            ]);

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
