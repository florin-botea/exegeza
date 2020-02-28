@extends('layouts.main')

@php
    $page_title = $article->title ?? 'no title';
    $page_description = $article->meta ?? 'no meta';
@endphp

@section('content')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v6.0"></script>
    <div class="row">
        <div class="col">
            @include('components.faded-verses', ['bible'=>$bible])
            <hr>
            <div class="">
                <article class="px-3 ck-content {{ $article->public ? '' : 'pending-article' }}">
                    @if ($article->published_by)
                        <section role="share" class="">
                            
                        </section>
                    @endif
                    <header class="mt-3">
                        <h1 class="text-center">{{ $article->title ?? '' }}</h1>
                        {{--<section class="text-right text-muted px-5">
                            <aside class="d-inline">admin</aside>
                            <time class="d-inline" datetime="{{ $article->created_at }}">-{{ \Carbon\Carbon::parse($article->created_at)->toDayDateTimeString() }}</time>
                        </section>--}}
                    </header>
                    {{--
                    <div class="box">
                        <blockquote class="p-3 bg-red-100 rounded text-justify text-lg">{{ $article->sample }}</blockquote>
                    </div>--}}
                    <div class="text-justify text-lg">{!! $article->content !!}</div>
                    <footer class="">
                        <aside class="text-right">
                            reads: 50
                        </aside>
                        <section class="">
                            <h6 class="">Tags:</h6>
                            @foreach ($article->tags??[] as $tag)
                            <span class="badge bg-gray-300 text-base">{{ $tag['value'] }}</span>
                            @endforeach
                        </section>
                    </footer>
                    <div class="d-flex justify-content-end">
                        @canany(['update','delete','publish','unpublish'], $article)
                        <a class="btn btn-success" href="{{ route('articles.edit', $article->id) }}"> Gestioneaza articol </a>
                        @endcan
                    </div>
                    <hr class="my-4">
                </article>

                @if ($article->published_by)
                    <section role="comments" class="">
                        <article class="">
                            <h2 class=""> Comments: </h2>
                            <div class="fb-comments" data-href="http://localhost:8080/articles/proin-pretium-sem-at-condimentum-volutpat-nunc-interdum-felis-at-ipsum-fringilla-auctor-id-eu-dui" data-width="" data-numposts="10"></div>
                        </article>
                    </section>

                    @include('components.similar-articles', ['articles'=>$article->related])

                    @include('components.most-popular-articles', ['articles'=>$popular_articles])
                @endif
            </div>
        </div>
    </div>
@endsection