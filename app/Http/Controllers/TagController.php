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
        $tagId = $request->input('tagId');
        $targetId = $request->input('targetId');
        $targetType = $request->input('targetType');
        $project = '';

        //TODO: Validate request, make sure user has appropriate access
        if($targetType == 'project'){
            $project = Project::find($targetId);
            $project->tags()->attach($tagId, [
                'user_id' => $request->user()->id,
            ]);
        }

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
        if($targetType == 'project'){
            $project = Project::find($targetId);
            $project->tags()->detach($tagId);

            $response['status'] = 1;
            $response['tags'] = $project->tags();
        }


        if($request->ajax){
            return Response::json($response);
        }

        return Redirect::back()->with('message', 'Removed tag ' . $tag->name . '.');

    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('query');

        $results = array(
            'suggestions' => array()
        );

        $queries = DB::table('tags')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->limit(5)->get();

        foreach ($queries as $query) {
            $results['suggestions'][] = [ 'data' => $query->id, 'value' => $query->name ];
        }
        return Response::json($results);
    }
}
