@extends('layouts.main')

@php
    $scripts = [];
    if ($bible->book->chapter) {
        $scripts[] = 'verses-section.js';
    }
@endphp

@section('content')
<div class="row">
    <div class="col">
        <section class="">
            <div class="d-flex">
                <h1>Cartea '{{ $bible->book->name }}'</h1>
                @can('manage bibles')
                    <button class="btn py-0 btn-outline-success align-self-center" data-toggle="modal" data-target="#book-form-modal">
                        <i class="far fa-edit"></i> Edit
                    </button>
                @endcan
            </div>
            <nav role="chapters-pagination" aria-label="...">
                <ul class="pagination flex-wrap">
                    @foreach($bible->book->chapters??[] as $chapter)
                        <li class="page-item m-1 {{ request()->chapter === $chapter->index ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="{{ $chapter->name }}">
                            <a class="page-link" href="{{ route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $chapter->index]) }}">{{ $chapter->index }}</a>
                        </li>
                    @endforeach
                    @can('manage bibles')
                        @if(!$bible->book->chapter)
						<li class="nav-item align-self-center">
							<button class="nav-link btn py-0 btn-outline-success" data-toggle="modal" data-target="#chapter-form-modal">
								<i class="fas fa-plus"></i> Add
							</button>
                        </li>
                        @endif	
					@endcan
                </ul>
                <div class="d-flex justify-content-between">
                    @if (request()->chapter > 0)
                        <p class="page-item">
                            <a class="page-link" href="{{ request()->chapter == 1 ? route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug]) : route('bible-versions.books.chapters.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>request()->chapter-1]) }}">Previous</a>
                        </p>
                        @else
                        <p class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </p>
                    @endif
                    @if ($bible->book->chapters->count() && request()->chapter < $bible->book->chapters->last()->index)
                        <p class="page-item">
                            <a class="page-link" href="{{ route('bible-versions.books.chapters.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>request()->chapter+1]) }}">Next</a>
                        </p>
                        @else
                        <p class="page-item disabled">
                            <span class="page-link">Next</span>
                        </p>
                    @endif
                </div>
            </nav>
            
            @if ($bible->book->chapter)
            <div class="d-flex">
                <h2>{{ $bible->book->chapter->name }}</h2>
                @can('manage bibles')
                    <button class="btn py-0 btn-outline-success align-self-center" data-toggle="modal" data-target="#chapter-form-modal">
                        <i class="far fa-edit"></i> Edit
                    </button>
                @endcan
            </div>
            <section class="verses-section">
                @foreach($bible->book->chapter->verses as $verse)
                    <p class="">{{ $verse->index.' '.$verse->text }}</p>
                @endforeach
            </section>
            @endif
        </section>
        <hr>
        <section role="articles-section">
            <div class="d-flex justify-content-between">
                <h2 class="mb-4">Articole</h2>
                <a class="btn btn-outline-success align-self-center" href="{{ $bible->book->chapter ? route('bible-versions.books.chapters.articles.create', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>$bible->book->chapter->index]) : route('bible-versions.books.articles.create', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug]) }}">
                    <i class="far fa-plus-square"></i> New
                </a>
            </div>

{{--
            @include('components.articles-filter')

            @foreach ($articles??[] as $article)
                @include('components.article-sample', [
                    'article' => $article, 
                    'article_url' => route('articles.show', $article->slug)
                ])
            @endforeach
--}}
<articles-list :bible="{{ $bible->id }}" :book="{{ $bible->book->index }}" :chapter="{{ $bible->book->chapter ? $bible->book->chapter->index : null }}"></articles-list>
        </section>
    </div>
</div>
@can('manage bibles')
    @include('forms.book-form-modal', ['book'=>$bible->book])
    @include('forms.chapter-form-modal', ['chapter'=>$bible->book->chapter, 'next_index'=>$bible->book->chapters->last() ? ($bible->book->chapters->last()->index + 1) : 1])
@endcan
@endsection