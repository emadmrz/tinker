<!--article begins-->
<article class="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="title">
                {{$article->title}}
            </div>
        </div>
        <div class="panel-body">

            <div class="clearfix"></div>
            <div class="media">
                <div class="media-right media-full-image">
                    <div class="menu-object">
                        <img class="media-object" src="{{asset('images/files/'.$article->image)}}" alt="...">
                    </div>
                </div>
                <div class="media-body">
                    <div class="article-mini-content">
                        <p class="text-justify">
                            {!! $article->content !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="article-full-details">
                <ul class="list-inline details">
                    <li class="writer">
                        <i class="fa fa-user"></i>
                        نویسنده :
                        <a href="#">{{$article->user->full_name}}</a>
                    </li>
                    <li class="time">
                        <i class="fa fa-calendar"></i>
                        تاریخ انتشار :
                        {{$article->shamsi_created_at}}
                    </li>
                    <li class="category">
                        <i class="fa fa-tags"></i>
                        <a href="#">{{$article->category->name}}</a>
                    </li>
                    <li class="category">
                        <i class="fa fa-user"></i>
                        <a href="#">2 بازدید</a>
                    </li>
                    <li class="category">
                        <i class="fa fa-comment"></i>
                        <a href="#"><span class="num_comment">{{$article->num_comment}}</span> دیدگاه</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</article>
<!--article ends-->
<!--tags begins-->
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right session-tags">
            <div class="row">
                <div class="col-sm-2">
                    <i class="fa fa-tags"></i>
                    برچسب ها :
                </div>
                <div class="col-sm-10 tags-container">
                    <ul>
                        @foreach($article->tags as $tag)
                        <li><a href="#">{{$tag->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--tags ends-->
<!--comment begins -->
<div class="comment-container">
    <div class="panel panel-default">
        <div class="comment-panel">
            <div class="panel-heading">
                <div class="title">
                    نظرات و دیدگاه ها
                </div>
            </div>
            <div class="panel-body">
                <div class="comment-list">
                    <!--all comments begins-->
                    <ul class="media-list">

                        <!--each comment begins note:add reply class to li for reply style-->
                        @include('comment.commentList')
                        <!--each comment ends-->

                        <!--comment form begins-->
                        @can('login')
                        @include('comment.commentForm')
                        @endcan
                        <!--comment form ends-->
                    </ul>
                    <!--all comments ends-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--comment ends-->