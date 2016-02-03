<nav class="navbar navbar-default main-nav">
    <div class="container nav-container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="{{url('/')}}">
                <img src="{{asset('images/tinker2.png')}}">
            </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right right-menu">
                <li class="active"><a href="#">صفحه اصلی</a></li>
                <li><a href="#">دوره های آموزشی</a></li>
                <li><a href="#">شروع یک استارت آپ</a></li>
                <li><a href="#">درباره ما</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-left left-menu">
                <li class="register">
                    <a href="{{url('/register')}}">
                        <button class="btn btn-xs btn-learn register">
                            <i class="fa fa-lock"></i>
                            عضویت در سایت
                        </button>
                    </a>
                </li>
                <li class="login">
                    <a href="{{url('/login')}}">
                        <button class="btn btn-xs btn-default login">
                            <i class="fa fa-user"></i>
                            ورود به سایت
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>