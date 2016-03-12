<!DOCTYPE html>
<html>
<head lang="fa">
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    @if(isset($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif
    @if(isset($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

@include('partials.navbar')

<div class="container">
    <div class="row">
        <div class="col-sm-7">
            <div class="col-sm-8">@yield('left_aside')</div>
            <div class="col-sm-8">@yield('right_aside')</div>
        </div>
        <div class="col-sm-9">@yield('content')</div>
    </div>
</div>

@include('partials.footer')

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
@yield('script')

</body>
</html>