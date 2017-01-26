<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Need;
use Redirect;
use Response;
use App\TaggerFactory;
use DB;

class NeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $needs = Need::all();
        return view('needs.index', compact('needs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('needs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags|max:255',
        ]);

        $need = new Need;
        $need->name = $request->input('name');
        $need->user_id = $request->user()->id;
        $need->save();

        return Redirect::route('needs.index')->with('message', 'Created new need: ' . $need->name . '!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Need $need)
    {
        // TODO: Role-based access
        if ($request->user()->id == 1) {
            $need->delete();

            return Redirect::route('needs.index')->with('message', 'Deleted need: ' . $need->name . '.');
        }
    }

    public function attach(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $targetId = $request->input('targetid');
        $targetType = $request->input('targettype');

        $need = !empty($id) ? Need::find($id) : Need::where('name', $name)->first();
        if(empty($need)){
            $need = new Need();
            $need->name = $name;
            $need->user_id = $request->user()->id;
            $need->save();
        }

        //TODO: Validate request, make sure user has appropriate access
        $targetObj = TaggerFactory::find($targetType, $targetId);

        if($targetObj != NULL && method_exists($targetObj, 'needs')){
            // Only attach a tag if it's not already attached to the project
            if($targetObj->needs()->where('needs.id', $need->id)->count() == 0){
                $targetObj->needs()->attach($need->id, [
                    'user_id' => $request->user()->id,
                ]);
            }

            $response['status'] = 1;
            $response['attached'] = $targetObj->needs()->get();
        }
        if($request->ajax()){
            return Response::json($response);
        }

        return Redirect::back()->with('message', 'Added need: ' . $need->name . '.');
    }

    public function detach(Request $request){
        $response = array(
            'status' => 0,
        );

        $id = $request->input('id');
        $need = Need::find($id);

        $target_id = $request->input('targetid');
        $target_type = $request->input('targettype');
        $target_obj = TaggerFactory::find($target_type, $target_id);

        if($target_obj != NULL && method_exists($target_obj, 'needs')){
            $target_obj->needs()->detach($id);

            $response['status'] = 1;
            $response['attached'] = $target_obj->needs()->get();
        }


        if($request->ajax()){
            return Response::json($response);
        }

        return Redirect::back()->with('message', 'Removed ' . $need->name . '.');

    }

    public function autocomplete(Request $request)
    {
        $term = $request->input('query');

        $results = array();

        $queries = DB::table('needs')
            ->where('name', 'LIKE', '%'.$term.'%')
            ->limit(5)->get();

        foreach ($queries as $query) {
            $results[] = [ 'value' => $query->id, 'name' => $query->name ];
        }
        return Response::json($results);
    }

    public function get(Request $request, $target_id)
    {
        $path = $request->path();
        $path_arr = explode('/', $path);
        $controller = $path_arr[0];

        $target_obj = TaggerFactory::find($controller, $target_id);

        if($target_obj != NULL && method_exists($target_obj, 'needs')){
            $needs = $target_obj->needs()->get();
            return Response::json($needs);
        }
    }
}
