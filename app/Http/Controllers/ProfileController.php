<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('profiles.edit', compact('profile'));
    }

    public function editOwn(Request $request)
    {

        $user = Auth::user();
        $profile = $user->profile()->first();

        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $user = $profile->user;
        $this->validate($request, [
            'email' => 'required|max:255',
            Rule::unique('users')->ignore($user->id),
        ]);

        $profile->first_name = $request->input('first_name', $profile->first_name);
        $profile->last_name = $request->input('last_name', $profile->last_name);
        $profile->city = $request->input('city', $profile->city);
        $profile->country = $request->input('country', $profile->country);
        $profile->bio = $request->input('bio', $profile->bio);

        if($request->hasFile('profile_image')){
            $file_path = base_path() . '/storage/app/public/profiles';
            $timestamp = time();

            $file = $request->profile_image;
            $file_ext = $file->getClientOriginalExtension();

            $hash = hash_file('MD5', $file->getRealPath());
            $new_filename = 'profile-' . $timestamp . '_' . $hash . '.' . $file_ext;

            $file->move($file_path, $new_filename);

            // If Imagick extension is available, crop and resize the image
            if(extension_loaded('Imagick')){
                $image = new \Imagick($file_path . '/' . $new_filename);
                $image->cropThumbnailImage(100,100);
                $image->writeImage($file_path . '/' . $new_filename);
            }
            $profile->image_url = $new_filename;
        }

        $profile->save();

        return redirect()->back()->with('message', 'Profile saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
