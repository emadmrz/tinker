<li class="media @if($newComment->parent_id==0) level1 @else reply @endif" data-article-value="{{$article->id}}" data-comment-value="{{$newComment->id}}">
    <div class="media-right">
        <a href="#">
            <?php
            $owner=$newComment->user;
            ?>
            <img class="media-object" src="{{asset('images/files/'.$owner->id.'/'.$owner->avatar)}}" alt="">
        </a>
    </div>
    <div class="media-body comment-media">
        <a class="comment-author" href="#">
            {{$newComment->user->full_name}}
        </a>

        <div class="pull-left date-container">
            <span class="comment-date">{{$newComment->day_shamsi_created_at}} |</span>
            @if($newComment->parent_id==0)
            <a class="pull-left reply-button" href="#"> پاسخ</a>
            @endif
        </div>

        <p>
            {{$newComment->content}}
        </p>
    </div>
</li>