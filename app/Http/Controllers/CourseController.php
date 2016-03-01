<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;

class CourseController extends Controller
{
    private $user;

    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    public function create()
    {
        $mainCategories = Category::roots()->lists('name', 'id');
        $main = [];
        $main[0] = 'انتخاب کنید';
        foreach ($mainCategories as $key => $value) {
            $main[$key] = $value;
        }
        //dd($mainCategories);
        return view('course.create', compact('main'))->with(['title' => 'افزودن دوره آموزشی']);
    }

    public function store(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'name' => 'required|min:3',
            'active' => 'required|in:0,1',
            'description' => 'required|min:3',
            'sub_category_id' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024',
            'tags.*'=>'min:2|max:30'
        ]);
        $input = $request->all();
        /* check if the user has uploaded image or not */
        if ($request->hasFile('image')) {
            $image = $input['image'];
            $imageName = $user->id . str_random(20) . '.' . $image->getClientOriginalExtension();
            $dbImageName = $user->id . '/' . $imageName;
            $image->move(public_path() . '/images/files/' . $user->id, $imageName);
        } else {
            $dbImageName = '';
        }

        /*create course*/
        $course = $user->courses()->create([
            'name' => $input['name'],
            'description' => $input['description'],
            'sub_category_id' => $input['sub_category_id'],
            'active' => $input['active'],
            'price' => $input['price'],
            'image' => $dbImageName
        ]);

        /*register tags*/
        $selected = $this->registerTags($request);
        if(!$selected){
            return redirect()->back();
        }
        $course->tags()->sync($selected);

        Flash::success(trans('users.courseCreated'));
        return redirect()->back();
    }

    public function edit(Course $course)
    {
        $user = $this->user;
        $mainCategories = Category::roots()->lists('name', 'id');
        $main = [];
        $main[0] = 'انتخاب کنید';
        foreach ($mainCategories as $key => $value) {
            $main[$key] = $value;
        }
        $subCategory=Category::findOrFail($course->sub_category_id);
        $subCategories=$subCategory->siblingsAndSelf()->lists('name','id');
        $selectedMainCategory=$subCategory->getAncestors()->first()->id;
        $tagsQuery = $course->tags();
        $tags = $tagsQuery->lists('name','name');
        $selected = $tagsQuery->lists('name')->toArray();
        return view('course.edit', compact('course', 'main'))->with([
            'title' => 'ویرایش دوره',
            'tags'=>$tags,
            'selectedTag'=>$selected,
            'selectedSubCategory'=>$subCategory->id,
            'selectedMainCategory'=>$selectedMainCategory,
            'subCategories'=>$subCategories
        ]);
    }

    public function update(Course $course,Request $request){
        $user = $this->user;
        $this->validate($request, [
            'name' => 'required|min:3',
            'active' => 'required|in:0,1',
            'description' => 'required|min:3',
            'sub_category_id' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024'
        ]);
        $input = $request->all();
        $previousImage = $course->image;
        /* check if the user has uploaded image or not */
        if ($request->hasFile('image')) {
            $image = $input['image'];
            $imageName = $user->id . str_random(20) . '.' . $image->getClientOriginalExtension();
            $dbImageName = $user->id . '/' . $imageName;
            $image->move(public_path() . '/images/files/' . $user->id, $imageName);
            if ($previousImage != null) {
                if (File::exists(public_path() . '/images/files/'. $previousImage)) {
                    unlink(public_path() . '/images/files/'. $previousImage);
                }
            }
        } else {
            $dbImageName = $previousImage;
        }

        /*create course*/
        $course->update([
            'name' => $input['name'],
            'description' => $input['description'],
            'sub_category_id' => $input['sub_category_id'],
            'active' => $input['active'],
            'price' => $input['price'],
            'image' => $dbImageName
        ]);

        /*register tags*/
        $selected = $this->registerTags($request);
        if(!$selected){//if the selected tags has error
            return redirect()->back();
        }
        $course->tags()->sync($selected);

        Flash::success(trans('users.courseUpdated'));
        return redirect()->back();
    }

    /**
     * Created By Dara on 22/2/2016
     * show course list in admin panel
     */
    public function adminIndex(){
        $user=$this->user;
        $courses=Course::all();
        return view('course.adminIndex',compact('courses'))->with(['title'=>'دوره های آموزشی']);
    }

    /**
     * Created By Dara on 14/2/2016
     * register tags for course
     */
    private function registerTags($request)
    {
        $selected = $request->input('tags');
        if(count($selected)>4){ //the user can select up to 4 tags
            //do nothing
        }else{
            $selectedIds=[];
            foreach($selected as $select){
                if($tag=Tag::where('name',$select)->first()){ //already exists
                    $selectedIds[]=$tag->id;
                }else{
                    $newTag=Tag::create(['name'=>$select]);
                    $selectedIds[]=$newTag->id;
                }
            }
            return $selectedIds;
        }
        return false;
    }

    /**
     * Created By Dara on 28/2/2016
     * show all course in the main site
     */
    public function index(){

    }

    /**
     * Created By Dara on 28/2/2016
     * show the selected course in the main site
     */
    public function show(Course $course){
        $user=$this->user;
        $obj=$course;
        $model='course'; //use to distinct options (id of the reply button)
        $comments=$course->comments;
        return view('course.show',compact('course','user','comments','obj'))->with([
            'title'=>$course->name,
            'model'=>$model
        ]);
    }
}
