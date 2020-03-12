<nav role="breadcrumb-sitemap-search" class="px-24 py-4 bg-white w-full">
	<div role="breadcrumb-menuContainer" class="">
		<ul role="breadcrumb-menuList" class="flex border-b-2 border-pink-700">
            @foreach ($bibles as $version)
                <li class="px-2 py-1 rounded mx-2 my-1 shadow-inner bg-red-700 text-white font-bold">
                    <a class="nav-link" href="{{ route('bible-versions.show', [$version->slug]) }}">{{ $version->alias }}</a>
                </li>
            @endforeach
        </ul>

        <div role="searchForm" class="shadow-inner flex justify-between p-2">
            <div role="map-route" class="flex">
                @if (isset($bible) && $bible->relationLoaded('book') && $bible->book)
                    <a class="text-2xl font-serif font-semibold text-purple-900" href=""><i class="fas fa-book"></i> F<span class="text-lg text-blue-700">acerea</span></a>
                    @if ($bible->book->relationLoaded('chapter') && $bible->book->chapter)
                        <span class="self-end text-sm font-semibold text-purple-800">, capitolul {{ $bible->book->chapter->index }}</span>
                    @endif{{-- $bible->book->name --}}
                    @else
                        <h1 class="inline text-lg font-serif font-semibold text-purple-900"><i class="fas fa-home"></i> Home</h1>
                @endif
            </div>
            <div class="">
                <form class="prevent-multiple-submit flex justify-end">
                    <input placeholder="word" class="px-4 rounded-l shadow-md">
                    <button type="submit" class="px-2 py-0 bg-green-800 text-yellow-300 rounded-r shadow-md"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="">
            @if (isset($bible) && $bible->relationLoaded('book') && $bible->book && $bible->book->chapters)
                <ul class="flex flex-wrap font-monospace font-semibold text-pink-800">
                    @foreach ($bible->book->chapters as $chapter)
                        <a href=""><li class="px-1 m-1 border border-pink-800 rounded hover:underline hover:text-pink-600 hover:shadow-none shadow-md">{{ $chapter->index }}</li></a>
                    @endforeach
                </ul>
            @endif
        </div>
	</div>
</nav>