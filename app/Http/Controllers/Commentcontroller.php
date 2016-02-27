<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    private $user;

    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * Created By Dara on 8/2/2016
     * add reply to comment
     */
    public function article(Article $article, $comment_id, Request $request)
    {

        $user = $this->user;
        $this->validate($request, [
            'content' => 'required'
        ]);
        if ($comment_id) { //check if the comment has been set or not (reply) level 2 comment
            $comment = Comment::findOrFail($comment_id);
            $parent_id = $comment->id;
            $msg = trans('users.answerSent');
            $nested = true;
        } else { //level 1 comment
            $parent_id = 0;
            $msg = trans('users.commentSent');
            $nested = false;
        }
        //add comment to db
        $newComment = $article->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'parent_id' => $parent_id
        ]);
        $numComment = $article->comments()->count();
        $article->update(['num_comment' => $numComment]);
        return [
            'hasCallback' => 1,
            'callback' => 'article_comment',
            'hasMsg' => 1,

            'msgType' => '',
            'msg' => $msg,
            'returns' => [
                'newComment' => view('article.partials.comment', compact('newComment', 'article', 'user'))->render(),
                'nested' => $nested,
                'numComment' => $numComment
            ]
        ];


    }

    /**
     * return reply form to view
     */
    public function showReply(Article $article, Comment $comment, Request $request)
    {
        $user = $this->user;
        return [
            'returns' => view('article.partials.commentReplyForm', compact('comment', 'article', 'user'))->render()
        ];

    }
}
