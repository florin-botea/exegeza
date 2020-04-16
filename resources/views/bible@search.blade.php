@extends('bible')

@section('bible_content')
    <main class="p-2 shadow-md mb-8">
        @if ($verses->count())
            <section class="verses-section">
                @foreach($verses as $verse)
                    <p class="mb-2 text-blue-900 text-lg font-serif">
                        <a class="text-blue-800 hover:text-blue-600"
                        href="{{ route('bible-versions.books.chapters.show', [$verse->bible->slug, $verse->book->slug, $verse->chapter_index]) }}">
                            [{{ $verse->book->alias.'. '.$verse->chapter_index.':'.$verse->index }}]
                        </a>
                        {{ $verse->text }}
                    </p>
                @endforeach
            </section>

            @if ($verses->hasPages())
            <nav class="flex flex-end justify-center bg-gray-200 p-2 shadow-inner">
                @if ($verses->currentPage() > 1)
                <a class="px-1 m-1 bg-white border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md"
                href="{{ $verses->previousPageUrl() }}">
                    <<
                </a>
                @endif

                @for ($i = 1; $i <= $verses->lastPage(); $i++)
                <a class="px-1 m-1 bg-white border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md {{ $verses->currentPage() == $i ? 'underline text-pink-600' : '' }}"
                    href="{{ $verses->url($i) }}">
                        {{ $i }}
                    </a>
                @endfor

                @if ($verses->hasMorePages())
                <a class="px-1 m-1 bg-white border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md"
                href="{{ $verses->nextPageUrl() }}">
                    >>
                </a>
                @endif
            </nav>
            @endif
        @endif
    </main>
@endsection