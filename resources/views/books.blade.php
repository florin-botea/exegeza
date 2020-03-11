@extends('layouts.main')

@php
    $articles_list = [
        'base_url' => "/api/articles?published=1&bible=1&book=1",
    ];
@endphp

@section('content')
	<section class="flex flex-wrap">
		<section class="w-1/2">
			<h2>VT</h2>
			<ul class="">
				@foreach($bible->books['vt']??[] as $vtBook)
					<li class="">
						<a class="" href="{{ route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$vtBook->slug]) }}">{{ $vtBook->name }}</a>
					</li>
				@endforeach
			</ul>
		</section>
		<section class="w-1/2">
			<h2>NT</h2>
			<ul class="">
				@foreach($bible->books['nt']??[] as $ntBook)
					<li class="">
						<a class="" href="{{ route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$ntBook->slug]) }}">{{ $ntBook->name }}</a>
					</li>
				@endforeach
			</ul>
		</section>
	</section>

	@include('components.most-popular-articles', ['articles' => $popular_articles])
	@include('components.recent-articles', ['articles' => $last_articles])

	<h1>Arhiva</h1>
	@include('components.articles-list', ['articles_list' => $articles_list])
@endsection