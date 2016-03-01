@if(count($articles)>0)
    @foreach($articles as $article)
        <!--each article begins-->
        <article class="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="title">
                        {{$article->title}}
                    </div>
                </div>
                <div class="panel-body">
                    <div class="article-details">
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
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="media">
                        <div class="media-right">
                            <div class="menu-object">
                                <img class="media-object" src="{{asset('images/files/'.$article->image)}}" alt="...">
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="article-mini-content">
                                <p class="text-justify">
                                    {!! $article->content !!}
                                </p>
                                <a href="{{route('article.show',$article->id)}}" class="btn btn-learn">ادامه مطلب ...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <!--each article ends-->
    @endforeach
@else
    <span style="color: #ff685d">مقداری برای نمایش وجود ندارد</span>
@endif