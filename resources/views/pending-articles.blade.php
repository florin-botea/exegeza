@extends('layouts.main')

@section('content')
    @foreach ($articles as $article)
        @include('components.article-sample', ['article'=>$article, 'article_url'=>route('pending-articles.show', $article->id)])
    @endforeach
@endsection