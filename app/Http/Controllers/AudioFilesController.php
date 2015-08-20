<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Track;
use App\AudioFile;
use Input;
use Redirect;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AudioFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store an audio file temporarily
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeTemp(Request $request)
    {
      $date = Carbon::now();
      $timestamp = $date->getTimestamp();

      $file = Input::file('audio');

      $temp_file = $file->getRealPath();
      $hash = hash_file('md5', $temp_file);

      $filename = $timestamp . '_' . $hash . '.' . $file->getClientOriginalExtension();
      Storage::disk('local')->put($filename,  File::get($file));
      //$file->move(base_path() . '/public/audio/temp/', $filename);

      return Response::json(array(

          'files' => array(
            '0' => array(
              'name' => $filename,
            ),
          ),
      ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
