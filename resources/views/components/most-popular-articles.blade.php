<h2 class="text-2xl font-bold"> Most popular </h2>
<ul class="text-justify">
    @foreach ($articles as $article)
        <li class="shadow bg-white rounded p-2">
            <a href="" class="font-semibold text-lg hover:underline">{{ $article->title }}</a>
            <a href="" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
            <span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
        </li>
    @endforeach
</ul>