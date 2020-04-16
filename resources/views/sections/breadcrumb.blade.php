<nav role="breadcrumb-sitemap-search" class="pt-4 px-1 bg-white w-full relative shadow-md mb-4">
	<div role="breadcrumb-menuContainer" class="">
		<ul role="breadcrumb-menuList" class="flex border-b-2 border-pink-700">
            @foreach ($bibles->where('public', 1) as $version)
                <li class="px-2 py-1 rounded mx-2 my-1 shadow-inner bg-red-700 text-white font-bold">
                    <a class="nav-link" href="{{ route('bible-versions.show', [$version->slug]) }}">{{ $version->alias }}</a>
                </li>
            @endforeach
            @can ('manage bibles')
            @foreach ($bibles->where('public', 0) as $version)
                <li class="px-2 py-1 rounded mx-2 my-1 shadow-inner bg-red-700 text-white font-bold">
                    <a class="nav-link" href="{{ route('bible-versions.show', [$version->slug]) }}">{{ $version->alias }}</a>
                </li>
            @endforeach
            @endcan
        </ul>

        <div role="searchForm" class="shadow-inner flex flex-wrap justify-between p-2">
            <div role="map-route" class="flex w-full sm:w-auto">
                @if (isset($bible) && $bible->book)
                    <a class="text-2xl font-serif font-semibold text-purple-900" href="{{ route('bible-versions.books.show', [$bible->slug, $bible->book->slug]) }}"><i class="fas fa-book"></i>{{ substr($bible->book->name, 0, 1) }}<span class="text-lg text-blue-700">{{ substr($bible->book->name, 1) }}</span></a>
                    @if ($bible->book && $bible->book->chapter)
                        <span class="self-end text-sm font-semibold text-purple-800">, capitolul {{ $bible->book->chapter->index }}</span>
                    @endif{{-- $bible->book->name --}}
                    @else
                        <a href="/" class="inline text-lg font-serif font-semibold text-purple-900"><i class="fas fa-home"></i> Home</a>
                @endif
            </div>
            {{-- search-form --}}
            <div class="w-full sm:w-auto">
                <form class="prevent-multiple-submit flex justify-end" action="" method="GET">
                    <input name="search-word" value="{{ strlen(request()->query('search-word')) > 1 ? request()->query('search-word') : null }}" type="text" placeholder="word" class="px-4 rounded-l shadow-md">
                    <button type="submit" class="px-2 py-0 bg-green-800 text-yellow-300 rounded-r shadow-md"><i class="fas fa-search"></i></button>
                </form>
            </div>
            {{-- end:search-form --}}
        </div>
        <div class="">
            @if (request()->route()->getName() != 'articles.show' && isset($bible) && $bible->relationLoaded('book') && $bible->book && $bible->book->chapters)
                <ul class="flex flex-wrap font-monospace font-semibold text-pink-800">
                    @foreach ($bible->book->chapters as $chapter)
                        <a href="{{ route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $chapter->index]) }}"><li class="px-1 m-1 border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md">{{ $chapter->index }}</li></a>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</nav>