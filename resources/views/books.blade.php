@extends('layouts.explorable')

@php
    $articles_list = [
        'base_url' => "/api/articles?published=1&bible=1&book=1",
    ];
@endphp

@section('main')
	<div class="d-flex">
		<h1>{{ $bible->name }}</h1>
		@can('manage bibles')
			<button class="btn py-0 btn-outline-success align-self-center" data-toggle="modal" data-target="#bible-version-form-modal">
				<i class="far fa-edit"></i> Edit
			</button>
		@endcan
	</div>
	<div class="d-flex">
		<p class="h2">Carti:</p>
		@can('manage bibles')
			<button class="btn py-0 btn-outline-success align-self-center" data-toggle="modal" data-target="#book-form-modal">
				<i class="fas fa-plus"></i> Add
			</button>
		@endcan
	</div>

	<div class="row">
		<div class="col-md">
			<h4>Vechiul Testament</h4>
			<ul class="list-group list-unstyled">
				@foreach($bible->books['vt']??[] as $vtBook)
					<li class="">
						<a class="list-group-item list-group-item-action" href="{{ route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$vtBook->slug]) }}">{{ $vtBook->name }}</a>
					</li>
				@endforeach
			</ul>
		</div>
		<div class="col-md">
			<h4>Noul Testament</h4>
			<ul class="list-group list-unstyled">
				@foreach($bible->books['nt']??[] as $ntBook)
					<li class="">
						<a class="list-group-item list-group-item-action" href="{{ route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$ntBook->slug]) }}">{{ $ntBook->name }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>

	@include('components.most-popular-articles', ['articles' => $popular_articles])
	@include('components.recent-articles', ['articles' => $last_articles])

	<h1>Arhiva</h1>
	@include('components.articles-list', ['articles_list' => $articles_list])

	@can('manage bibles')
		@include('forms.book-form-modal', ['book'=>null])
		@include('forms.bible-version-form-modal', ['bible'=>$bible])
	@endcan
@endsection