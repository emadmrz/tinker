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
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024'
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
        $course->tags()->sync($selected);

        Flash::success(trans('users.courseCreated'));
        return redirect()->back();
    }

    public function edit(Course $course)
    {
        $mainCategories = Category::roots()->lists('name', 'id');
        $main = [];
        $main[0] = 'انتخاب کنید';
        foreach ($mainCategories as $key => $value) {
            $main[$key] = $value;
        }
        $tagsQuery = $course->tags();
        $tags = $tagsQuery->lists('name', 'id');
        $selectedTag = $tagsQuery->lists('id')->toArray();
        $subCategory=Category::findOrFail($course->sub_category_id);
        $subCategories=$subCategory->getSiblings()->lists('name','id');
        $selectedMainCategory=$subCategory->getAncestors()->first()->id;
        return view('course.edit', compact('course', 'main'))->with([
            'title' => 'ویرایش دوره',
            'tags'=>$tags,
            'selectedTag'=>$selectedTag,
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
        $course->tags()->sync($selected);

        Flash::success(trans('users.courseUpdated'));
        return redirect()->back();
    }

    /**
     * Created By Dara on 14/2/2016
     * register tags for course
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
