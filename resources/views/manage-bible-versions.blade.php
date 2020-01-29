@extends('layouts.main')

@section('content')
	<main class="p-2 shadow">
		@form(['action'=>route('bible-versions.store')])
			<p class="h3">Adauga o noua versiune</p>
			@include('forms.bible-version', ['method'=>'post', 'action'=>route('bible-versions.create')])
		@endform
		<hr>
		<p class="h3">Actualizeaza o versiune</p>
		@foreach ($bibleVersions as $bible)
			@include('forms.bible-version', ['model'=>$bible, 'method'=>'put', 'action'=>route('bible-versions.update', $bible->id)])
		@endforeach
	</main>
@endsection