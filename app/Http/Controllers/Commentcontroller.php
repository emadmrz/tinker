<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class Commentcontroller extends Controller
{
    /**
     * Created By Dara on 8/2/2016
     * add comment for article via ajax
     */
    public function store(Article $article, Request $request)
    {
        if ($request->ajax()) { //check if the request has been made by ajax
            $user = $request->user();
            $this->validate($request, [
                'content' => 'required'
            ]);
            $comment = $article->comments()->create([
                'user_id' => $user->id,
                'content' => $request->input('content')
            ]);
            $num_comments = $article->comments()->count();
            $article->update(['num_comment' => $num_comments]);
            return [
                'hasCallback' => 1,
                'callback'=>'article_comment',
                'hasMsg'=>1,
                'msgType'=>'',
                'msg'=>trans('users.commentSent'),
                'returns'=>[
                    'num_comments'=>$num_comments,
                    'new_comment'=>view('article.partials.comment',compact('comment','article'))->render()
                ]
            ];
        }else{//the request aint Ajax
            return 'error';
        }
    }
}
