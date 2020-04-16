@extends('layouts.main')

@php
    $page_title = $article->title ?? 'no title';
    $page_description = $article->meta ?? 'no meta';
    $bible_resource_url = $bible->book->chapter ? route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $bible->book->chapter->index]) : route('bible-versions.books.show', [$bible->slug, $bible->book->slug]);
@endphp

@section('content')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v6.0"></script>
    <div class="row">
        <div class="col">
            <div class="flex justify-between">
                <a href="{{ $bible_resource_url }}" class="block font-bold text-blue-800 hover:text-blue-600">
                    <- Catre {{ $bible->book->chapter ? 'capitol' : 'carte' }} 
                </a>
                @canany(['update','delete','publish','unpublish'], $article)
                    <a class="block font-bold text-green-800 hover:text-green-600" href="{{ route('articles.edit', $article->id) }}"> Gestioneaza articol </a>
                @endcan
            </div>
            <hr>
            <div class="">
                <article class="px-3 ck-content {{ $article->public ? '' : 'pending-article' }}">
                    @if ($article->published_by)
                        <section role="share" class="pt-4">
                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <div class="addthis_inline_share_toolbox"></div>
                        </section>
                    @endif
                    <header class="my-4">
                        <h1 class="text-center font-bold text-xl font-serif text-gray-800">{{ $article->title ?? '' }}</h1>
                        {{--<section class="text-right text-muted px-5">
                            <aside class="d-inline">admin</aside>
                            <time class="d-inline" datetime="{{ $article->created_at }}">-{{ \Carbon\Carbon::parse($article->created_at)->toDayDateTimeString() }}</time>
                        </section>--}}
                    </header>
                    {{--
                    <div class="box">
                        <blockquote class="p-3 bg-red-100 rounded text-justify text-lg">{{ $article->sample }}</blockquote>
                    </div>--}}
                    <div class="text-justify mb-2">{!! $article->content !!}</div>
                    <footer class="mb-6">
                        <section role="tags" class="bg-gray-100 p-2 mb-2">
                            @foreach ($article->tags??[] as $tag)
                                <span class="font-semibold text-sm px-2 mr-1 bg-gray-300 rounded">{{ $tag['value'] }}</span>
                            @endforeach
                        </section>
                        <section role="author-card" class="flex py-4 px-8 bg-gray-100">
                            <div class="w-full text-right px-4 leading-tight">
                                <time class="text-sm text-gray-700">{{ $article->created_at }}</time>
                                <h2 class="mb-1 font-bold">
                                    <a href="{{ route('users.show', [$article->author->id]) }}">{{ $article->author->name }}</a>
                                </h2>
                                <p class="text-gray-700 text-sm">{{ $article->author->details ? $article->author->details->bio : 'no user bio' }}</p>
                            </div>
                            <div class="w-1/6 bg-red-300">
                                <figure class="w-full relative" style="padding-bottom:100%">
                                    <img src="{{ $article->author->getPhotoUrl() }}" class="absolute bg-gray-300 w-full">
                                </figure>
                            </div>
                        </section>
                    </footer>
                </article>

                @if ($article->published_by)
                <!-- data-href= link de pornire, ? article=[&comment=, in caz de notificare] -->
                <section role="comments" class="{{ auth()->user() ? '' : '_unauthenticated' }} px-6 mb-6" id="comments-container" data-src="/api/comments?article={{$article->id}}">

                </section>

                @if (count($article->related))
                <section role="articles-samples-list" class="bg-gray-100">
                    <div class="flex justify-between">
                        <h5 class="inline text-xl font-serif font-semibold text-purple-900">
                            Articole similare
                        </h5>
                    </div>
                    <div role="articles-list" class="p-2">
                        @foreach ($article->related as $article)
                            @include('components.article-sample', ['article' => $article])
                            <hr class="my-4">
                        @endforeach
                    </div>
                </section>
                @endif
                @endif
            </div>
        </div>
    </div>
@endsection