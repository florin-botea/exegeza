@extends('layouts.main')

@section('content')
	<div class="row">
		<div class="col-md-4">
			@include('sections.bible-search')
		</div>
		<div class="col-md-8">
			<p class="h2">Traduceri disponibile:</p>
			<nav class="navbar navbar-expand px-0">
				<ul class="navbar-nav d-flex flex-wrap">
					@foreach ($bibleVersions as $bible)
						<li class="nav-item">
							<a class="nav-link" href="{{ route('bible-versions.show', ['bible_version'=>$bible->slug]) }}">{{ $bible->alias }}</a>
						</li>
					@endforeach
					@can('manage bibles')
						<li class="nav-item align-self-center">
							<button class="nav-link btn py-0 btn-outline-success" data-toggle="modal" data-target="#bible-version-form-modal">
								<i class="fas fa-plus"></i> Add
							</button>
						</li>	
					@endcan
				</ul>
			</nav>
			<section class="jumbotron">
				<h1 class="text-right">Lorem Ipsum</h1>
				<p class="lead">
					Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
				</p>
			</section>
		</div>
	</div>
	@can('manage bibles')
		@include('forms.bible-version-form-modal', ['bible'=>null, 'next_index'=>$bibleVersions->last() ? ($bibleVersions->last()->index + 1) : 1])
	@endcan
	
@endsection