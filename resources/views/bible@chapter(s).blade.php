@extends('bible')

@section('bible_content')
    <main class="p-2 shadow-md mb-8">
        @if ($bible->book->chapter)
            <section class="verses-section">
                @foreach($bible->book->chapter->verses as $verse)
                    <p class="mb-2 text-blue-900 text-lg font-serif">{{ $verse->index.'. '.$verse->text }}</p>
                @endforeach
            </section>

            <nav class="flex justify-between bg-gray-200 p-2 shadow-inner">
                @if ($bible->book->chapter->index > 1)
                <a class="px-1 m-1 bg-white border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md"
                href="{{ route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $bible->book->chapter->index-1]) }}">
                    Capitolul {{ $bible->book->chapter->index - 1 }}
                </a>
                @endif
                @if ($bible->book->chapters->last()->index > $bible->book->chapter->index)
                <a role="spacer"></a>
                <a class="px-1 m-1 bg-white border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md"
                href="{{ route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $bible->book->chapter->index+1]) }}">
                    Capitolul {{ $bible->book->chapter->index + 1 }}
                </a>
                    @else
                    <a class="px-1 m-1">
                        Sfarsit de carte
                    </a>
                @endif
            </nav>
        @endif
    </main>
@endsection