<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use Redirect;

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

    public function destroy(Request $request, Tag $tag){
        // TODO: Role-based access
        if($request->user()->id == 1){
            $tag->delete();

            return Redirect::route('tags.index')->with('message', 'Deleted tag ' . $tag->name . '.');
        }
    }
}
