@extends('main.layout')
@section('aside')
    @include('course.partials.skillPanel')
    @include('course.partials.pricePanel')
    @include('main.partials.relatedArticles')
@endsection
@section('content')
    <div class="panel panel-default main-course">
        <div class="panel-heading course-heading">
            <div class="title">
                <i class="fa fa-graduation-cap fa-lg"></i>
                {{$session->title}}
            </div>
            <div class="course-buy-num pull-left">
                <a class="btn btn-learn" href="#">
                    تاریخ انتشار {{$session->shamsi_created_at}}
                </a>
            </div>
        </div>
        <div class="panel-body">
            <div class="description text-right text-justify">
                <p>
                    {{$session->description}}
                </p>
            </div>
            <button class="btn btn-learn">دانلود این قسمت</button>
            <div class="image text-center">
                <video id="example_video_1" class="video-js vjs-default-skin"
                       controls preload="auto"
                       poster="{{asset('images/files')}}/{{$session->course->image}}"
                       data-setup='{"example_option":true}'>
                    <source src="{{route('session.showVideo',[$session->file])}}" type='video/mp4'/>

                </video>
            </div>
            <div class="text-right">
                            <span class="text-muted">
                                برای دانلود و مشاهده هر قسمت روی آن کلیک کنید.
                            </span>
            </div>
            <!--course sessions begins-->
            <div class="text-center course-sessions">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        @foreach($course->sessions as $key=>$session)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td class="text-right">
                                    <a href="#">
                                        <i class="fa fa-play-circle-o fa-lg"></i>
                                                    <span class="session-title">
                                                        {{$session->title}}
                                                    </span>
                                        @if($course->price>0)
                                        @else
                                            <span class="pull-left free-session">رایگان</span>
                                        @endif
                                    </a>
                                </td>
                                <td>14:14</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <!--course sessions ends-->
        </div>
    </div>

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
                            @foreach($session->tags as $tag)
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
@endsection