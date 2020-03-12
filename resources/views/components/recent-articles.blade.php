<h2 class="text-2xl font-bold"> Most recent </h2>
<ul class="text-justify">
    @foreach ($articles as $article)
        <li class="shadow bg-white rounded p-2">
            <a href="">
                <h2 class="font-semibold text-lg hover:underline inline">{{ $article->title }}</h2>
            </a>
            <a href="" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
            <span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
            <a>
                <p class="px-2 bg-gray-100">{{ $article->sample }}</p>
            </a>
        </li>
    @endforeach
</ul>