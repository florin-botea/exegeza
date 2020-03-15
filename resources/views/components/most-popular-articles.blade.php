<h2 class="text-lg font-bold text-pink-800 font-serif"> Most popular </h2>
<ul class="text-justify">
    @foreach ($articles as $article)
        <li class="">
            <a href="" class="font-semibold text-base hover:underline font-bold text-blue-900 hover:text-blue-600">{{ $article->title }}</a>
            <a href="" class="text-sm text-gray-700 hover:underline">[{{ $article->author->name }} - </a>
            <span class="text-sm text-gray-700">{{ $article->updated_at }}]</span>
        </li>
    @endforeach
</ul>