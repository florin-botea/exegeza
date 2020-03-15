<h2 class="text-lg font-bold text-pink-800 font-serif"> Most recent </h2>
<ul class="text-justify pr-8">
    @foreach ($articles as $article)
        <li class="p-2">
            <a href="">
                <h2 class="font-semibold text-lg hover:underline inline text-blue-900">{{ $article->title }}</h2>
            </a>
            <a href="" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
            <span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
            <a>
                <p class="px-2 text-blue-900">{{ $article->sample }}</p>
            </a>
        </li>
    @endforeach
</ul>