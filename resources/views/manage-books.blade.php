@extends('layouts.main')

@section('content')
	<main class="p-2 shadow">
		<p class="h3">Adauga o noua carte</p>
		@include('forms.book', ['form_id'=>'create', 'action'=>route('bible-versions.books.store', $bible->id) ])
		<hr>
		<p class="h3">Actualizeaza o versiune</p>
		@foreach ($bible->books as $book)
			@include('forms.book', [
				'action'=>route('bible-versions.books.update', [$bible->id, $book->id]), 
				'model'=>$book,
				'model_url' => route('bible-versions.books.chapters.index', [$bible->slug, $book->slug])
			])
		@endforeach
	</main>
@endsection