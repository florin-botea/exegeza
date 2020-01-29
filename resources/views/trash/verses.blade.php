@extends('layouts.main')

@section('content')
	<div class="row">
		<div class="col">
			<section class="">
				<h1>Cartea '{{ $bible->book->name }}'</h1>
				@include('sections.bible-pagination', ['bible'=>$bible??null])
				<h2>{{ $bible->book->chapter->name }}</h2>
				<ul class="list-unstyled text-justify">
					@foreach ($bible->book->chapter->verses??[] as $verse)
					<li class="h4">
						<span class="badge">{{ $verse->index }}.</span>
						{{ $verse->text }}
					</li>
					@endforeach
				</ul>
			</section>
			<hr>
			@include('sections.articles-section', [
				'articles' => [],
				'article_create_url' => route('bible-versions.books.chapters.articles.create', [$bible->slug, $bible->book->slug, $bible->book->chapter->index])
			])
		</div>
	</div>
@endsection