<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Response;

class PersonController extends Controller
{
    public function show(User $user)
    {
        $current_user =  Auth::user();
        $profile = $user->profile()->get()->first();

        // If the logged in user is the same as the user being viewed or is admin, create a new
        // profile if one does not already exist.
        if(empty($profile) && ($current_user->id == $user->id || $current_user->roles->contains(1))){
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->save();
        }
        return view('people.show', compact('profile'));
    }

    public function showSelf(Request $request)
    {
        $user = $request->user();
        return redirect()->route('people.show', ['user' => $user]);
    }

    public function edit(Request $request, User $user){
        $profile = $user->profile()->get()->first();
        if (empty($profile) || Gate::denies('update-profile', $profile))
        {
            abort(403);
        }

        return view('people.edit', compact('profile'));
    }

    public function update(Request $request, User $user){
        $profile = $user->profile()->get()->first();

        if (empty($profile) || Gate::denies('update-profile', $profile))
        {
            abort(403);
        }

        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => [
                'email',
                'required',
                'max:255',
                Rule::unique('users')->where(function ($query) use ($user){
                    $query->where('id', '!=', $user->id);
                }),
            ],
            'username' => [
                'required',
                'min:4',
                'max:50',
                Rule::unique('users', 'name')->where(function ($query) use ($user){
                    $query->where('id', '!=', $user->id);
                }),
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profile->first_name = $request->input('first_name', $profile->first_name);
        $profile->last_name = $request->input('last_name', $profile->last_name);
        $profile->city = $request->input('city', $profile->city);
        $profile->country = $request->input('country', $profile->country);
        $profile->bio = $request->input('bio', $profile->bio);
        $user->name = $request->input('username', $user->name);
        $user->email = $request->input('email', $user->email);

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
        $user->save();

        return redirect()->back()->with('message', 'Profile saved!');
    }

    public function exists($username)
    {
        $user = \App\User::Where('name', $username)->first();

        $response = [];
        if(!empty($user)){
            $response = $user;
        }
        return Response::json($response);
    }
}
