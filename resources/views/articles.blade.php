@extends('layouts.main')

@section('content')
    @isset ($articles)
    <div class="flex justify-between">
        <div class="bg-blue-400 flex-1 p-2">
            <h5 class="inline text-xl font-serif font-semibold text-blue-800 leading-none"> Articole </h5>
            <label for="filters" class="cursor-pointer text-blue-100 hover:text-blue-600"> filtre </label>
        </div>
    </div>
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
@endsection