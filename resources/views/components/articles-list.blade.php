<div class="">
    <div class="flex justify-between">
        <div class="">
            <h5 class="inline text-xl font-serif font-semibold text-purple-900"> Articole </h5>
            <label for="filters" class="cursor-pointer hover:text-blue-600"> filtre </label>
        </div>
        <a href="{{ route('articles.create', ['bible-version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>($bible->book->chapter ? $bible->book->chapter->index : 0)]) }}" class="block font-bold text-blue-800 hover:text-blue-600"> +Adauga articol </a>
    </div>
    <input type="checkbox" id="filters" class="checked:next-hidden-show" hidden>
    <div role="filters" class="hidden">
        <form role="filters" class="flex">
            <div class="pr-2">
                <label for="keyword" class="block"> cuvant cheie </label>
                <input name="keyword" id="keyword" class="input-w-full" type="text">
            </div>
            <div class="pr-2">
                <label for="author" class="block"> autor </label>
                <input name="author" id="author" class="input-w-full" type="text">
            </div>
            <div class="pr-2">
                <label for="cite" class="block"> citat din </label>
                <input name="cite" id="cite" class="input-w-full" type="text">
            </div>
            <div class="pr-2">
                <label for="language" class="block"> language </label>
                <select name="language" id="language" class="input-w-full">
                    <option value=""> toate </option>
                    <option value=""> romana </option>
                    <option value=""> engleza </option>
                </select>
            </div>
            <div class="pr-2">
                <label for="sort" class="block"> sort </label>
                <select name="sort" id="sort" class="input-w-full">
                    <option value="date-asc"> date asc </option>
                    <option value="date-desc"> date desc </option>
                </select>
            </div>
            <button class="self-end" type="submit"> Aplica </button>
        </form>
    </div>

    <div role="articles-list" class="p-2">
        @foreach ($articles as $article)
            <article class="">
                <div class="flex">
                    <div class="w-1/2">
                        <h1 class="font-semibold text-lg hover:underline text-blue-900"> 
                            <a href=""> {{ $article->title }} </a>
                        </h1>
                    </div>
                    <div class="flex w-1/2 pl-4">
                        <figure class="relative w-1/5" style="padding-top:20%;">
                            <img src="" class="absolute top-0 w-full bg-gray-400" style="padding-top:100%">
                        </figure>
                        <div class="px-2 text-gray-600">
                            <h2 class="font-bold">{{ $article->author->name }}</h2>
                            <p class="text-sm font-semibold leading-none"> user short description here </p>
                            <p class="text-sm"> citat din: cartea x, autor y </p>
                            <time class="text-sm">{{ $article->updated_at }}</time>
                        </div>
                    </div>
                </div>
                <p class="text-justify text-blue-900"> {{ $article->sample }} </p>
            </article>
        @endforeach
    </div>
</div>