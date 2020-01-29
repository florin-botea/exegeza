@extends('layouts.main')

@section('content')
	<main class="p-2 shadow">
		<p class="h3">Adauga un nou capitol</p>
		@include('forms.chapter', ['action'=>route('bible-versions.books.chapters.store', [$bible->id, $bible->book->id]) ])
		<hr>
		<p class="h3">Actualizeaza un capitol</p>
		@foreach ($bible->book->chapters as $chapter)
			@include('forms.chapter', [
				'action' => route('bible-versions.books.chapters.update', [$bible->id, $bible->book->id, $chapter->id]),
				'model'=> $chapter,
				'model_url' => route('bible-versions.books.chapters.verses.index', [$bible->slug, $bible->book->slug, $chapter->index]),
			])
		@endforeach
	</main>
@endsection