@extends('layouts.main')

@php
    $articles_list = [
        'base_url' => "/api/articles?published=1&bible=1&book=1",
    ];
@endphp

@section('content')
	<section class="flex flex-wrap mb-2 mb-4">
		<section class="w-1/2">
			<h2 class="text-xl font-bold text-pink-800 font-serif">
				<i class="fas fa-cross text-sm"></i>Vechiul Testament
			</h2>
			<ul class="px-2">
				@foreach($bible->books['vt']??[] as $vtBook)
					<li class="">
						<span class="inline-block bg-pink-800 h-2 w-2 rounded-full"></span>
						<a class="text-md font-bold hover:underline text-blue-900 hover:text-blue-600" href="{{ route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$vtBook->slug]) }}">
							{{ $vtBook->name }}
						</a>
					</li>
				@endforeach
			</ul>
		</section>
		<section class="w-1/2">
			<h2 class="text-xl font-bold text-pink-800 font-serif">
				<i class="fas fa-cross text-sm"></i>Noul Testament
			</h2>
			<ul class="px-2">
				@foreach($bible->books['nt']??[] as $ntBook)
					<li class="">
						<span class="inline-block bg-pink-800 h-2 w-2 rounded-full"></span>
						<a class="text-md font-bold hover:underline text-blue-900 hover:text-blue-600" href="{{ route('bible-versions.books.show', ['bible_version'=>$bible->slug, 'book'=>$ntBook->slug]) }}">
							{{ $ntBook->name }}
						</a>
					</li>
				@endforeach
			</ul>
		</section>
	</section>
	{{--
	<div class="flex flex-wrap p-2">
		<section class="w-1/2 pr-2">
			@include('components.most-popular-articles', ['articles' => $popular_articles])
		</section>
		<section class="w-1/2 pl-2">
			@include('components.recent-articles', ['articles' => $last_articles])
		</section>
	</div>

	Cauta in arhiva--}}
@endsection