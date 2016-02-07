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
                        <img class="media-object" src="{{asset('images/files/'.$article->user->id.'/'.$article->image)}}" alt="...">
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
                        <a href="#">ابزار طراحی</a>
                    </li>
                    <li class="category">
                        <i class="fa fa-user"></i>
                        <a href="#">2 بازدید</a>
                    </li>
                    <li class="category">
                        <i class="fa fa-comment"></i>
                        <a href="#">5 دیدگاه</a>
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
                        <!--each comment begins-->
                        <li class="media">
                            <div class="media-right">
                                <a href="#">
                                    <img class="media-object" src="images/person1.jpg" alt="">
                                </a>
                            </div>
                            <div class="media-body comment-media">
                                <a class="comment-author" href="#">
                                    احمد دارا
                                </a>

                                <div class="pull-left date-container">
                                    <span class="comment-date">در سه شنبه 06 بهمن 1394  |</span>
                                    <a class="pull-left" href="#"> پاسخ</a>
                                </div>

                                <p>
                                    سلام خسته نباشید من دوره قبل رو دیدم خیلی عالی بود ممنون ولی
                                    وقتی رو شروع یادگیری این دوره کلیک میکنم گزینه پرداخت نمیاد مشکل
                                    چیه؟ممنون میشم اگه راهنمایی کنید
                                </p>
                            </div>
                        </li>
                        <li class="media reply">
                            <div class="media-right">
                                <a href="#">
                                    <img class="media-object" src="images/person1.jpg" alt="">
                                </a>
                            </div>
                            <div class="media-body comment-media">
                                <a class="comment-author" href="#">
                                    احمد دارا
                                </a>

                                <div class="pull-left date-container">
                                    <span class="comment-date">در چهارشنبه 07 بهمن 1394</span>
                                </div>

                                <p>
                                    سلام خسته نباشید من دوره قبل رو دیدم خیلی عالی بود ممنون ولی
                                    وقتی رو شروع یادگیری این دوره کلیک میکنم گزینه پرداخت نمیاد مشکل
                                    چیه؟ممنون میشم اگه راهنمایی کنید
                                </p>
                            </div>
                        </li>
                        <li class="media">
                            <div class="media-right">
                                <a href="#">
                                    <img class="media-object" src="images/person1.jpg" alt="">
                                </a>
                            </div>
                            <div class="media-body comment-media">
                                <a class="comment-author" href="#">
                                    احمد دارا
                                </a>

                                <div class="pull-left date-container">
                                    <span class="comment-date">در سه شنبه 06 بهمن 1394  |</span>
                                    <a class="pull-left" href="#"> پاسخ</a>
                                </div>

                                <p>
                                    سلام خسته نباشید من دوره قبل رو دیدم خیلی عالی بود ممنون ولی
                                    وقتی رو شروع یادگیری این دوره کلیک میکنم گزینه پرداخت نمیاد مشکل
                                    چیه؟ممنون میشم اگه راهنمایی کنید
                                </p>
                            </div>
                        </li>
                        <!--each comment ends-->
                        <li class="media comment-form">
                            <div class="media-right">
                                <a href="#">
                                    <img class="media-object" src="images/person1.jpg" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <form class="form-horizontal" action="#">
                                                        <textarea class="form-control"
                                                                  placeholder="لطفا نظر خود را وارد نمایید ..."
                                                                  name="body" id=""></textarea>
                                    <button type="submit" class="btn btn-learn">
                                        <i class="fa fa-paper-plane-o"></i>
                                        ارسال نظر
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <!--all comments ends-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--comment ends-->