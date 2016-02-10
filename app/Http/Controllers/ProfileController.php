<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'))->with(['title' => $user->full_name]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'first_name' => 'required',
            'last_name'=>'required',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024'
        ]);
        $input=$request->all();
        $previousImage=$user->image;
        /* check if the user has uploaded image or not */
        if($request->hasFile('image')){
            $image=$input['image'];
            $imageName=$user->id.str_random(20).'.'.$image->getClientOriginalExtension();
            $image->move(public_path().'/images/files/'.$user->id,$imageName);
            /* Delete the previous image */
            if($previousImage!=null){
                if(File::exists(public_path().'/images/files/'.$user->id.'/'.$previousImage)){
                    unlink(public_path().'/images/files/'.$user->id.'/'.$previousImage);
                }
            }
        }else{
            $imageName=$previousImage;
        }

        $user->update([
            'first_name'=>$input['first_name'],
            'last_name'=>$input['last_name'],
            'image'=>$imageName
        ]);
        Flash::success(trans('users.profileUpdated'));
        return redirect()->back();
    }
}
