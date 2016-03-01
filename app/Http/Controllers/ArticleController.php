<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

class ArticleController extends Controller
{
    private $user;

    public function __construct(Request $request){
        $this->user=$request->user();
    }
    public function index()
    {
        $articles=Article::where('published',1)->get();
        return view('article.index',compact('articles'))->with(['title'=>'مقالات']);
    }

    public function show(Article $article){
        $user=$this->user;
        $comments=$article->comments;
        $obj=$article;
        $model='article';
        return view('article.show',compact('article','user','comments','obj'))->with([
            'title'=>$article->title,
            'model'=>$model
        ]);
    }

    /**
     * Created By Dara on 6/2/2016
     * upload image in summernote
     */
    public function upload(Request $request)
    {
        if ($request->ajax()) {
            $user = $request->user();
            /* upload image */
            $imageName = str_random(20) . $user->id . '.' . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(public_path() . '/images/files/' . $user->id, $imageName);
            return asset('images/files/' . $user->id . '/' . $imageName);
        } else {
            abort(403);
        }
    }

    /**
     * Created By Dara on 6/2/2016
     * delete image in summernote
     */
    public function delete(Request $request)
    {
        $user = $request->user();
        $path = parse_url($request->input('src'), PHP_URL_PATH);
        $pathFragments = explode('/', $path);
        $imageName = end($pathFragments);
        $path = public_path('images/files/' . $user->id . '/' . $imageName);
        if (File::exists($path)) {
            unlink($path);
        }

    }

    public function create()
    {
        $user = $this->user;
        $mainCategories = Category::roots()->lists('name', 'id');
        $main = [];
        $main[0] = 'انتخاب کنید';
        foreach ($mainCategories as $key => $value) {
            $main[$key] = $value;
        }
        return view('article.create',compact('main'))->with(['title' => 'ثبت مقاله جدید']);
    }

    public function store(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'title' => 'required|min:3',
            'published' => 'required|in:0,1',
            'content' => 'required|min:3',
            'sub_category_id' => 'required|integer',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024',
            'tags.*'=>'string|max:30|min:2',
        ]);
        $input = $request->all();
        /* check if the user has uploaded image or not */
        if ($request->hasFile('image')) {
            $image = $input['image'];
            $imageName = $user->id . str_random(20) . '.' . $image->getClientOriginalExtension();
            $imageDbName=$user->id.'/'.$imageName;
            $image->move(public_path('images/files/'.$user->id),$imageName);
        } else {
            $imageDbName = '';
        }

        /*create article*/
        $article = $user->articles()->create([
            'title' => $input['title'],
            'content' => $input['content'],
            'published' => $input['published'],
            'image' => $imageDbName,
            'sub_category_id'=>$request->input('sub_category_id')
        ]);

        /*register tags*/
        $selected = $this->registerTags($request);
        if(!$selected){//if the selected tags has error
            return redirect()->back();
        }
        $article->tags()->sync($selected);

        Flash::success(trans('users.articleCreated'));
        return redirect()->back();
    }

    public function edit(Article $article)
    {
        $user = $this->user;
        $mainCategories = Category::roots()->lists('name', 'id');
        $main = [];
        $main[0] = 'انتخاب کنید';
        foreach ($mainCategories as $key => $value) {
            $main[$key] = $value;
        }
        $subCategory=Category::findOrFail($article->sub_category_id);
        $subCategories=$subCategory->siblingsAndSelf()->lists('name','id');
        $selectedMainCategory=$subCategory->getAncestors()->first()->id;
        $tagsQuery = $article->tags();
        $tags = $tagsQuery->lists('name','name');
        $selected = $tagsQuery->lists('name')->toArray();

        return view('article.edit', compact('article', 'user', 'tags', 'selected'))->with([
            'title' => 'ویرایش مقاله',
            'main'=>$main,
            'subCategories'=>$subCategories,
            'selectedMainCategory'=>$selectedMainCategory,
            'selectedSubCategory'=>$subCategory->id,
        ]);
    }

    public function update(Article $article, Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'title' => 'required|min:3',
            'published' => 'required|in:0,1',
            'content' => 'required|min:3',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024',
            'tags.*'=>'min:2|max:30',
            'sub_category_id'=>'required|integer'
        ]);
        $input = $request->all();
        $previousImage = $article->image;
        /* check if the user has uploaded image or not */
        if ($request->hasFile('image')) {
            $image = $input['image'];
            $imageName = $user->id . str_random(20) . '.' . $image->getClientOriginalExtension();
            $imageDbName = $user->id.'/'.$imageName;
            $image->move(public_path() . '/images/files/' . $user->id, $imageName);
            /* Delete the previous image */
            if ($previousImage != null) {
                if (File::exists(public_path() . '/images/files/' . $user->id . '/' . $previousImage)) {
                    unlink(public_path() . '/images/files/' . $user->id . '/' . $previousImage);
                }
            }
        } else {
            $imageDbName = $previousImage;
        }

        /*update article*/
        $article->update([
            'title' => $input['title'],
            'content' => $input['content'],
            'published' => $input['published'],
            'image' => $imageDbName,
            'sub_category_id'=>$input['sub_category_id']
        ]);

        /*register tags*/
        $selected = $this->registerTags($request);
        $article->tags()->sync($selected);

        Flash::success(trans('users.articleEdited'));
        return redirect()->back();
    }

    /**
     * Created By Dara on 22/2/2016
     * show list of articles in admin panel
     */
    public function adminIndex(){
        $articles=Article::all();
        return view('article.adminIndex',compact('articles'))->with(['title'=>'مقالات']);
    }

    /**
     * Created By Dara on 6/2/2016
     * register tags for article
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


}
