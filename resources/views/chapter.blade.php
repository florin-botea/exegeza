@extends('layouts.main')

@php
    $scripts = [];
    if ($bible->book->chapter) {
        $scripts[] = 'verses-section.js';
    }
    $articles_list = [
        'base_url' => "/api/articles?published=1&bible=1&book=1",
    ];
@endphp

@section('content')
<div class="row">
    <div class="col">
        <section class="p-2">
            @if ($bible->book->chapter)
                <section class="verses-section">
                    @foreach($bible->book->chapter->verses as $verse)
                        <p class="mb-2 text-blue-900 text-lg font-serif">{{ $verse->index.' '.$verse->text }}</p>
                    @endforeach
                </section>
            @endif
        </section>

        <hr class="mb-4">
	
        <section class="mb-4 bg-gray-100">
            @include('components.articles-list', ['articles' => $articles])
        </section>
    
        <hr class="mb-4">
    
        <div class="pr-2 flex bg-gray-100">
            <section class="w-2/3">
                @include('components.recent-articles', ['articles' => $last_articles])
            </section>
            <section class="w-1/3">
                @include('components.most-popular-articles', ['articles' => $popular_articles])
            </section>
        </div>
    </div>
</div>
@endsection