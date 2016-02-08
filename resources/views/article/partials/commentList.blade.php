@foreach($article->comments as $comment)
    <li class="media">
        <div class="media-right">
            <a href="#">
                <img class="media-object" src="" alt="">
            </a>
        </div>
        <div class="media-body comment-media">
            <a class="comment-author" href="#">
                {{$comment->user->full_name}}
            </a>

            <div class="pull-left date-container">
                <span class="comment-date">{{$comment->day_shamsi_created_at}} |</span>
                <a class="pull-left" href="#"> پاسخ</a>
            </div>

            <p>
                {{$comment->content}}
            </p>
        </div>
    </li>
@endforeach