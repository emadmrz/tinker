@extends('main.layout')
@section('aside')
    @include('main.partials.sessions')
@endsection
@section('content')
    @include('article.partials.articlePreview')
@endsection