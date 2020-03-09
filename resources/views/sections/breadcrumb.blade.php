<nav role="breadcrumb-sitemap-search" class="px-24 py-4 bg-gray-700">
	<div role="breadcrumb-menuContainer" class="">
		<ul role="breadcrumb-menuList" class="flex border-b-2 border-gray-900">
            @foreach ($bibles as $version)
                <li class="px-2 py-1 rounded mx-2 my-1 shadow-inner bg-red-700 text-white font-bold">
                    <a class="nav-link" href="#">{{ $version->alias }}</a>
                </li>
            @endforeach
        </ul>

        <div role="searchForm" class="shadow-inner flex p-2">
            <div role="map-route" class="flex">
                @if (isset($bible) && $bible->relationLoaded('book') && $bible->book)
                    <a class="text-2xl font-semibold text-white text-shadow-md" href="">{{ $bible->book->name }}</a>
                    @if ($bible->book->relationLoaded('chapter') && $bible->book->chapter)
                        <span class="self-end text-lg font-semibold text-white">, capitolul {{ $bible->book->chapter->index }}</span>
                    @endif
                @endif
            </div>
            <div class="self-end w-full">
                @form(['class'=>'flex justify-end'])
                        <input type="text" placeholder="word" class="px-4 rounded-l shadow-md">
                        <button type="submit" class="px-2 bg-green-800 text-yellow-300 rounded-r shadow-md"><i class="fas fa-search"></i></button>
                @endform
            </div>
        </div>
	</div>
</nav>