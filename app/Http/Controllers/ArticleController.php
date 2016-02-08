<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;

class ArticleController extends Controller
{
    public function index()
    {
        $articles=Article::where('published',1)->get();
        return view('article.index',compact('articles'))->with(['title'=>'مقالات']);
    }

    public function show(Article $article){
        return view('article.show',compact('article'))->with(['title'=>$article->title]);
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
        $user = Auth::user();
        return view('article.create')->with(['title' => 'ثبت مقاله جدید']);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'title' => 'required|min:3',
            'published' => 'required|in:0,1',
            'content' => 'required|min:3',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024'
        ]);
        $input = $request->all();
        /* check if the user has uploaded image or not */
        if ($request->hasFile('image')) {
            $image = $input['image'];
            $imageName = $user->id . str_random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/files/' . $user->id, $imageName);
        } else {
            $imageName = '';
        }

        /*create article*/
        $article = $user->articles()->create([
            'title' => $input['title'],
            'content' => $input['content'],
            'published' => $input['published'],
            'image' => $imageName
        ]);

        /*register tags*/
        $selected = $this->registerTags($request);
        $article->tags()->sync($selected);

        Flash::success(trans('users.articleCreated'));
        return redirect()->back();
    }

    public function edit(Article $article)
    {
        $user = Auth::user();
        $tagsQuery = $article->tags();
        $tags = $tagsQuery->lists('name', 'id');
        $selected = $tagsQuery->lists('id')->toArray();
        return view('article.edit', compact('article', 'user', 'tags', 'selected'))->with(['title' => 'ویرایش مقاله']);
    }

    public function update(Article $article, Request $request)
    {
        $user = $request->user();
        $this->validate($request, [
            'title' => 'required|min:3',
            'published' => 'required|in:0,1',
            'content' => 'required|min:3',
            'image' => 'mimes:jpeg,bmp,png,jpg|max:1024'
        ]);
        $input = $request->all();
        $previousImage = $article->image;
        /* check if the user has uploaded image or not */
        if ($request->hasFile('image')) {
            $image = $input['image'];
            $imageName = $user->id . str_random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/files/' . $user->id, $imageName);
            /* Delete the previous image */
            if ($previousImage != null) {
                if (File::exists(public_path() . '/images/files/' . $user->id . '/' . $previousImage)) {
                    unlink(public_path() . '/images/files/' . $user->id . '/' . $previousImage);
                }
            }
        } else {
            $imageName = '';
        }

        /*update article*/
        $article->update([
            'title' => $input['title'],
            'content' => $input['content'],
            'published' => $input['published'],
            'image' => $imageName
        ]);

        /*register tags*/
        $selected = $this->registerTags($request);
        $article->tags()->sync($selected);

        Flash::success(trans('users.articleEdited'));
        return redirect()->back();
    }

    /**
     * Created By Dara on 6/2/2016
     * register tags for article
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
