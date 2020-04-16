@extends('bible')

@section('bible_content')
	<main class="flex flex-wrap mb-2 mb-4 pl-4 sm:pr-0">
		<section class="w-full sm:w-1/2">
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
		<section class="w-full sm:w-1/2">
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
	</main>
@endsection