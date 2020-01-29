<section class="position-relative {{ $bible->book->chapter ? 'blured-section' : ''}}">
    <div class="{{ $bible->book->chapter ? 'blured-content' : ''}}" style="top:0px;">
        <h1><a href="{{ $bible->book->chapter ? route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $bible->book->chapter->index]) : route('bible-versions.books.show', [$bible->slug, $bible->book->slug]) }}" class="text-dark">
            Cartea '{{ $bible->book->name }}'
        </a></h1>
        @if ($bible->book->chapter)
        <h2>{{ $bible->book->chapter->name }}</h2>
        @endif
        <ul class="list-unstyled text-justify" style="">
            @foreach ($bible->book->chapter->verses??[] as $verse)
            <li class="h4">
                <span class="badge">{{ $verse->index }}.</span>
                {{ $verse->text }}
            </li>
            @endforeach
        </ul>
    </div>
    @if ($bible->book->chapter)
    <div class="position-relative d-flex justify-content-center" style="z-index:2;">
        <button class="btn btn-sm btn-dark mx-auto js-unblur-section"> Arata continut </button>
    </div>
    @endif
</section>