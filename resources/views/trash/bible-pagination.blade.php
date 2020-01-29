<nav aria-label="...">
	<ul class="pagination flex-wrap">
		@foreach($bible->book->chapters??[] as $chapter)
			<li class="page-item m-1 {{ request()->chapter === $chapter->index ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="{{ $chapter->name }}">
				<a class="page-link" href="{{ route('bible-versions.books.chapters.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>$chapter->index]) }}">{{ $chapter->index }}</a>
			</li>
		@endforeach
	</ul>
	<div class="d-flex justify-content-between">
		@if (request()->chapter > 0)
			<p class="page-item">
				<a class="page-link" href="{{ request()->chapter === 0 ? route('bible-versions.books.chapters.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug]) : route('bible-versions.books.chapters.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>request()->chapter-1]) }}">Previous</a>
			</p>
			@else
			<p class="page-item disabled">
				<span class="page-link">Previous</span>
			</p>
		@endif
		@if ($bible->book->chapters->count() && request()->chapter < $bible->book->chapters->last()->index)
			<p class="page-item">
				<a class="page-link" href="{{ route('bible-versions.books.chapters.show', ['bible_version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>request()->chapter+1]) }}">Next</a>
			</p>
			@else
			<p class="page-item disabled">
				<span class="page-link">Next</span>
			</p>
		@endif
	</div>
</nav>