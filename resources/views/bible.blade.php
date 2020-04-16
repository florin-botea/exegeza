@extends('layouts.main')

@section('content')
    @yield('bible_content')

    @if (isset($articles))
    <section role="articles-samples-list" class="bg-gray-100">
        <div class="flex justify-between">
            <div class="bg-blue-400 flex-1 p-2">
                <h5 class="inline text-xl font-serif font-semibold text-blue-800 leading-none">
                    @if ($bible && $bible->book)
                    Articole la "{{ $bible->book->name }}"{{ $bible->book->chapter ? ', capitolul '.$bible->book->chapter->index : '' }}
                    <br>
                    <small class="text-white">({{ $bible->name }})</small>
                        @else
                        Articole la "{{ $bible->name }}"
                    @endif
                </h5>
                <label for="filters" class="cursor-pointer text-blue-100 hover:text-blue-600"> filtre </label>
            </div>
            @can('create',\App\Article::class)
            @if (in_array(request()->route()->getName(), ['bible-versions.books.chapters.show', 'bible-versions.books.show']))
            <a class="text-3xl"
            href="{{ route('articles.create', ['bible-version'=>$bible->slug, 'book'=>$bible->book->slug, 'chapter'=>($bible->book->chapter ? $bible->book->chapter->index : 0)]) }}#add-article">
                <button class="px-4 font-bold text-white bg-green-800 hover:bg-green-600" style="height:100%">
                    <i class="fas fa-file-medical"></i>
                </button>
            </a>
            @endif
            @endcan
        </div>
        @isset ($articles)
        <input type="checkbox" id="filters" class="checked:next-hidden-show" {{ request()->query() ? 'checked' : '' }} hidden>
        <div role="filters" class="hidden">
            @include('components.articles-filters')
        </div>
        @endisset
    
        @if (count($articles))
        <div role="articles-list" class="p-2">
            @foreach ($articles as $article)
                @include('components.article-sample', ['articles' => $articles])
                <hr class="my-4">
            @endforeach
        </div>
            @else
            <figure class="mb-4 flex p-2">
                <img class="w-20" src="/assets/no-data-icon-68.png">
                <p class="px-4 text-xl font-bold text-gray-500 self-center"> Niciun articol gasit </p>
            </figure>
        @endif
    </section>
    @endisset
@endsection