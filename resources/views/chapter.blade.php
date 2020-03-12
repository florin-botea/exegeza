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
                        <p class="">{{ $verse->index.' '.$verse->text }}</p>
                    @endforeach
                </section>
            @endif
        </section>
        <hr>
        {{--
        <section role="articles-section">
            <div class="d-flex justify-content-between">
                <h2 class="mb-4">Articole</h2>
                <a class="btn btn-outline-success align-self-center" href="{{ route('articles.create', ['bible-version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>($bible->book->chapter ? $bible->book->chapter->index : 0)]) }}">
                    <i class="far fa-plus-square"></i> New
                </a>
            </div>    
            @include('components.articles-list', ['articles_list'=>$articles_list])
            scroll in jos si se vor incarca tot mai multe articole, dar cele mai populare sunt primele
        </section>--}}
    </div>
</div>
@endsection