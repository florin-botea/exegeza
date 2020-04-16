<article class="leading-tight">
    <div class="flex flex-wrap">
        <div class="w-full mb-2 md:mb-0">
            <h1 class="font-semibold text-lg hover:underline text-blue-900"> 
                <a href="{{ route('articles.show', [$article->slug, 'user' => $article->author->id]) }}"> {{ $article->title }} </a>
            </h1>
        </div>
        <div class="flex flex-wrap justify-end md:items-start pl-2 w-full md:w-2/12 md:order-3">
            <div class="w-12 md:w-full order-last md:order-first">
                <figure class="w-full">
                    <img src="{{ $article->author->getPhotoUrl() }}" class="">
                </figure>
            </div>
            <div class="px-2 text-gray-600 text-right md:text-left">
                <h2 class="font-bold">
                    <a href="{{ route('users.show', $article->author->id) }}">{{ $article->author->name }}</a>
                </h2>
                <p class="text-sm font-semibold leading-none hidden md:block">{{ $article->author->getBio() }}</p>
                <p class="text-sm">{{ $article->cite_from }}</p>
                <time class="text-sm">{{ $article->updated_at }}</time>
            </div>
        </div>
        <p class="text-justify text-blue-900 p-1 md:w-10/12 md:order-2"> {{ $article->sample }} </p>
    </div>
</article>