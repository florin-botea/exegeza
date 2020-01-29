@extends('layouts.main')

@section('content')
	<div class="row">
		<div class="col">
			<section class="">
				<h1>Cartea '{{ $bible->book->name }}'</h1>
				@include('sections.bible-pagination', ['bible'=>$bible??null])
			</section>
			<hr>
			@include('sections.articles-section', [
				'articles' => [],
				'article_create_url' => route('bible-versions.books.articles.create', [$bible->slug, $bible->book->slug])
			])
		</div>
	</div>
@endsection