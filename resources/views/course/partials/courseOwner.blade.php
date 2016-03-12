<div class="panel panel-custom user-info panel-gray">
    <div class="panel-heading">
        مدرس دوره
    </div>
    <div class="panel-body">
        <div class="text-center">
            <div class="avatar">
                <img class="img-circle" src="{{ asset('img/persons/'.$course->user->avatar) }}" title="{{ $course->user->fullname }}" alt="{{ $course->user->fullname }}">
            </div>
            <h4>{{ $course->user->fullname }}</h4>
            <p class="text-muted">
                برنامه نویس ارشد PHP و فعال در حوزه کسب و کارهای نوپا، علاقه مند به پژوهش
            </p>
            <a href="#" class="btn btn-success btn-block btn-sm">سایر دوره ها</a>
        </div>

    </div>

</div>