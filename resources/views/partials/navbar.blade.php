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
                @can('login')
                <li class="login">
                    <a href="{{url('/profile')}}">
                        <button class="btn btn-xs btn-learn register">
                            <i class="fa fa-user"></i>
                            پنل کاربری
                        </button>
                    </a>
                </li>
                <li class="login">
                    <a href="{{url('/logout')}}">
                        <button class="btn btn-xs btn-default login">
                            <i class="fa fa-power-off"></i>
                            خروج
                        </button>
                    </a>
                </li>
                @else
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
                @endcan
            </ul>
        </div>
    </div>
</nav>

<div class="main-header">
    <div class="container">
        <div class="row tinker-row">
            <div class="col-md-4 col-md-push-1">
                <div class="tinker-box">
                    <h3 class="text-center tinker-title">تینکر یک رسانه آموزشی است.</h3>

                    <p class="text-center tinker-description">
                        باور ما اینست که کاربران ایرانی لایق بهترین ها هستند و باید بهترین و بروزترین فیلم های
                        آموزشی و مقالات در اختیار آنها قرار بگیرد تا بتوانند به سرعت پیشرفت کنند و جزء بهترین ها در
                        صنعت طراحی و برنامه نویسی وب شوند . با ما همراه باشید تا بهترین ها رو لایق بهترین کاربران
                        کنیم
                    </p>
                    <button class="btn btn-default btn-md center-block">درباره تینکر بیشتر بدانید</button>
                </div>
            </div>
            <div class="col-md-6 col-md-push-1">
                <div class="text-styler">
                    <div class="top-bar">
                        <div class="circles">
                            <div class="circle circle-red"></div>
                            <div class="circle circle-yellow"></div>
                            <div class="circle circle-green"></div>
                        </div>
                    </div>
                    <div class="window-content">
                        <div class="typer">
                            $ <span class="element"></span>
                        </div>
                        <div class="numbers-row">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>