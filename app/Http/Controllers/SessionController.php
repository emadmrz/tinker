<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Course;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
use Laracasts\Flash\Flash;

class SessionController extends Controller
{
    private $user;
    private $session_id;

    public function __construct(Request $request){
        $this->user=$request->user();
    }

    public function create(Course $course){
        return view('session.create',compact('course'))->with(['title'=>'افزودن جلسه']);
    }

    public function store(Course $course,Request $request){
        $user=$this->user;
        //dd($request->all());
        $this->validate($request,[
            'title'=>'required',
            'file'=>'required|mimes:mp4',
            'description'=>'required',
            'active'=>'required|in:0,1',
            'level'=>'required|in:1,2,3'
        ]);
        $input=$request->all();
        /*upload the video for the session*/
        if($request->hasFile('file')){
            $videoDbName=$this->uploadVideo($input['file']);
        }else{
            $videoDbName=null;
        }
        /*add the session in db*/
        $session=$course->sessions()->create([
            'user_id'=>$user->id,
            'title'=>$input['title'],
            'description'=>$input['description'],
            'active'=>$input['active'],
            'file'=>$videoDbName,
            'level'=>$input['level'],
        ]);
        $this->session_id=$session->id;

        /*add tags to the sessions*/
        $selected = $this->registerTags($request);
        $session->tags()->sync($selected);

        /*check for attachments*/
        if($request->hasFile('attachment')){
            $attachments=$input['attachment'];
            $this->uploadAttachments($attachments);
        }

        Flash::success(trans('users.sessionAdded'));
        return redirect()->back();

    }

    /**
     * Created By Dara on 15/2/2016
     * upload the video file for the session
     */
    private function uploadVideo($file){
        $user=$this->user;
        $videoName=$user->id.str_random(20).'.'.$file->getClientOriginalExtension();
        $videoDbName=$user->id.'/'.$videoName;
        $file->move(public_path('video/'.$user->id),$videoName);
        return $videoDbName;
    }

    /**
     * Created by Dara on 16/2/2016
     * upload attachments related to the session
     */
    private function uploadAttachments($attachments){
        $user=$this->user;
        /*validate attachments*/
        /*-------------------------------------------------*/
        foreach($attachments as $key=>$attachment){
            $attachmentName=$user->id.str_random(20).'.'.$attachment->getClientOriginalExtension();
            $attachmentDbName=$user->id.'/'.$attachmentName;
            $attachmentRealName=$attachment->getClientOriginalName();
            $attachment->move(public_path('images/files/'.$user->id),$attachmentName);
            $user->attachments()->create([
                'parentable_id'=>$this->session_id,
                'parentable_type'=>'App\Session',
                'real_name'=>$attachmentRealName,
                'size'=>$attachment->getClientSize(),
                'file'=>$attachmentDbName
            ]);
        }
    }

    /**
     * Created By Dara on 14/2/2016
     * register tags for session
     */
    private function registerTags($request)
    {
        $tags = Tag::all()->lists('name', 'id')->toArray();
        $selected = $request->input('tags');
        foreach ($selected as $key => $value) {
            if (!array_key_exists($value, $tags)) {
                $tag = Tag::create(['name' => $value]);
                unset($selected[$key]);
                $selected[] = $tag->id;
            }
        }
        return $selected;
    }
}
