<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Course;
use App\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use Mockery\CountValidator\Exception;

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
            'file'=>'required|max:50',
            'description'=>'required',
            'active'=>'required|in:0,1',
            'level'=>'required|in:1,2,3',
            'tags.*'=>'min:2|max:30',
        ]);
        $input=$request->all();

        /*check if the given link for video valid or not*/
        $fileName=$input['file'];//text-input
        if(Storage::disk('local')->exists($fileName)){
            //ok
            $path=storage_path('app/'.$fileName);
            $capacity=File::size($path);
        }else{ //not exists
            $fileName=null;
            $capacity=null;
        }

        /*add the session in db*/
        $session=$course->sessions()->create([
            'user_id'=>$user->id,
            'title'=>$input['title'],
            'description'=>$input['description'],
            'active'=>$input['active'],
            'file'=>$fileName,
            'level'=>$input['level'],
            'capacity'=>$capacity
        ]);
        $this->session_id=$session->id;

        /*add tags to the sessions*/
        $selected = $this->registerTags($request);
        $session->tags()->sync($selected);

        /*check for attachments*/
        if($request->hasFile('attachment')){
            $attachments=$input['attachment'];
            /*validate attachments*/
            /*-------------------------------------------------*/
            foreach($attachments as $key=>$attachment){
                $attachmentName=$user->id.'_'.$course->id.'_'.str_random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentRealName=$attachment->getClientOriginalName();
                Storage::disk('local')->put($attachmentName,File::get($attachment));
                $user->attachments()->create([
                    'parentable_id'=>$this->session_id,
                    'parentable_type'=>'App\Session',
                    'real_name'=>$attachmentRealName,
                    'size'=>round(($attachment->getClientSize())/1024,2),
                    'file'=>$attachmentName
                ]);
            }
        }

        Flash::success(trans('users.sessionAdded'));
        return redirect()->back();

    }

    public function edit(Course $course,Session $session){
        $user=$this->user;
        $tagsQuery = $session->tags();
        $tags = $tagsQuery->lists('name','name');
        $selected = $tagsQuery->lists('name')->toArray();
        return view('session.edit',compact('course','session'))->with([
            'title'=>'ویرایش جلسه',
            'tags'=>$tags,
            'selected'=>$selected
        ]);
    }

    /**
     * Created By Dara on 22/2/2016
     * update session
     */
    public function update(Course $course,Session $session,Request $request){
        $user=$this->user;
        $this->validate($request,[
            'title'=>'required',
            'file'=>'required|max:50',
            'description'=>'required',
            'active'=>'required|in:0,1',
            'level'=>'required|in:1,2,3',
            'tags.*'=>'min:2|max:30',
        ]);
        $input=$request->all();

        /*check if the given link for video valid or not*/
        $fileName=$input['file'];//text-input
        if(Storage::disk('local')->exists($fileName)){
            //ok
            $path=storage_path('app/'.$fileName);
            $capacity=File::size($path);
        }else{ //not exists
            $fileName=null;
            $capacity=null;
        }

        /*add the session in db*/
        $session->update([
            'title'=>$input['title'],
            'description'=>$input['description'],
            'active'=>$input['active'],
            'file'=>$fileName,
            'level'=>$input['level'],
            'capacity'=>$capacity
        ]);
        $this->session_id=$session->id;

        /*add tags to the sessions*/
        $selected = $this->registerTags($request);
        $session->tags()->sync($selected);

        /*check for attachments*/
        if($request->hasFile('attachment')){
            $attachments=$input['attachment'];
            /*validate attachments*/
            /*-------------------------------------------------*/
            foreach($attachments as $key=>$attachment){
                $attachmentName=$user->id.'_'.$course->id.'_'.str_random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentRealName=$attachment->getClientOriginalName();
                Storage::disk('local')->put($attachmentName,File::get($attachment));
                $user->attachments()->create([
                    'parentable_id'=>$this->session_id,
                    'parentable_type'=>'App\Session',
                    'real_name'=>$attachmentRealName,
                    'size'=>round(($attachment->getClientSize())/1024,2),
                    'file'=>$attachmentName
                ]);
            }
        }

        Flash::success(trans('users.sessionUpdated'));
        return redirect()->back();

    }

    /**
     * Created By Dara on 21/2/2016
     * get the video of the session
     */
    public function showVideo($videoName){
        $path = storage_path('app') . '/' . $videoName;

        $file =File::get($path);
        $type =File::mimeType($path);
        $headers = [
            'Content-Type'        => 'video/mp4',
            'Content-Length'      => File::size($path)
        ];
        return Response::stream(function() use ($path) {
            try {
                $stream = fopen($path, 'r');
                fpassthru($stream);
            } catch(Exception $e) {
                Log::error($e);
            }
        }, 200, $headers);
    }

    /**
     * Created By Dara on 21/2/2016
     * show the attachment of the session
     */
    public function downloadAttachmentFile($fileName){
        $path = storage_path('app') . '/' . $fileName;
        return response()->download($path, $fileName);

    }

    /**
     * Created By Dara on 21/2/2016
     * delete attachment
     */
    public function attachmentDelete(Session $session,Attachment $attachment,Request $request){
        $user=$this->user;
        if(Storage::disk('local')->exists($attachment->file)){
            Storage::delete($attachment->file);
        }else{
            //not exists
            die('not exists');
        }
        $attachment->delete();
        return [
            'msg'=>trans('users.attachmentDeleted')
        ];

    }

    /**
     * Created By Dara on 22/2/2016
     * show list of sessions related to specific course
     */
    public function adminIndex(Course $course){
        $sessions=$course->sessions()->get();
        return view('session.adminIndex',compact('sessions','course'))->with(['title'=>"جلسات $course->name"]);
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
