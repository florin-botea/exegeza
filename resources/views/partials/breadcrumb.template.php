<nav role="breadcrumb-sitemap-search" class="pt-4 px-1 bg-white w-full relative shadow-md mb-4">
	<div role="breadcrumb-menuContainer" class="">
		<ul role="breadcrumb-menuList" class="flex border-b-2 border-pink-700">
            <li p-foreach="$bibles->where('public', 1) as $version" class="my-1">
                <a class="px-2 py-1 rounded mx-2 text-white font-bold {{ isset($bible) && $bible->id == $version->id ? 'shadow-inner bg-red-700' : 'shadow-md hover:shadow-inner hover:bg-red-700 bg-pink-700' }}"
                href="{{ route('bible-versions.show', [$version->slug]) }}">{{ $version->alias }}</a>
            </li>
            <li p-if="auth()->user() && auth()->user()->can('manage bibles')" p-foreach="$bibles->where('public', 0) as $version" class="my-1">
                <a class="px-2 py-1 rounded mx-2 text-white font-bold {{ isset($bible) && $bible->id == $version->id ? 'shadow-inner bg-red-700' : 'shadow-md hover:shadow-inner hover:bg-red-700 bg-pink-700' }}"
                href="{{ route('bible-versions.show', [$version->slug]) }}">{{ $version->alias }}</a>
            </li>
        </ul>

        <div role="searchForm" class="shadow-inner flex flex-wrap justify-between p-2">
            <div role="map-route" class="flex w-full sm:w-auto">
                <template p-if="isset($bible) && $bible->book">
                    <a class="text-2xl font-serif font-semibold text-purple-900" href="{{ route('bible-versions.books.show', [$bible->slug, $bible->book->slug]) }}"><i class="fas fa-book"></i>{{ substr($bible->book->name, 0, 1) }}<span class="text-lg text-blue-700">{{ substr($bible->book->name, 1) }}</span></a>
                    <span p-if="$bible->book && $bible->book->chapter" class="self-end text-sm font-semibold text-purple-800">, capitolul {{ $bible->book->chapter->index }}</span>
                    <a p-else href="/" class="inline text-lg font-serif font-semibold text-purple-900"><i class="fas fa-home"></i> Home</a>
                </template>
            </div>
            <!-- search form -->
            <div p-if="request()->routeIs(['bible-versions.show', 'bible-versions.books.show'])" class="w-full sm:w-auto">
                <form class="prevent-multiple-submit flex justify-end" action="" method="GET">
                    <input name="search-word" value="{{ strlen(request()->query('search-word')) > 1 ? request()->query('search-word') : null }}" type="text" placeholder="word" class="px-2 rounded-l shadow-md">
                    <button type="submit" class="px-2 py-0 bg-green-800 text-yellow-300 rounded-r shadow-md"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <!-- end:search-form -->
        </div>
        <div p-if="request()->routeIs(['bible-versions.books.show', 'bible-versions.books.chapters.show', 'articles.create'])">
            <ul p-if="isset($bible) && $bible->book && $bible->book->chapters" class="flex flex-wrap font-monospace font-semibold text-pink-800">
                <li p-foreach="$bible->book->chapters as $chapter">
                    <a class="px-1 m-1 border border-pink-800 rounded hover:shadow-none shadow-md {{ $chapter->index == $bible->chapterIndex() ? 'bg-pink-800 text-white' : 'text-pink-800 hover:text-white hover:bg-pink-800' }}"
                    href="{{ route('bible-versions.books.chapters.show', [$bible->slug, $bible->book->slug, $chapter->index]) }}">{{ $chapter->index }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
