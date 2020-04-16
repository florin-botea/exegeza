@extends('user-page')

@section('tab')
    <section class="flex flex-wrap p-4">
        <div class="w-full sm:w-1/3 mb-4 sm:mb-0">
            <figure class="bg-gray-300">
                <img class="mx-auto" src="{{ $user->getPhotoUrl() }}">
            </figure>
        </div>
        <div class="w-full sm:w-2/3 sm:px-8">
            <table class="w-full">
                <tr>
                    <td> Nume: </td>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <td> Email: </td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td> Bio: </td>
                    <td>{{ $user->details ? $user->details->bio : '' }}</td>
                </tr>
            </table>
        </div>
    </section>
    @if ($user->details && $user->details->description && $user->details->description->content)
    <section class="px-4">
        <div class="ck-content break-normal">{!! $user->details->description->content !!}</div>
    </section>
    @endif  

    @if (isset($articles) && count($articles))
    <section class="px-2">
        <section role="articles-samples-list" class="bg-gray-100">
            <h2 class="inline text-xl font-serif font-semibold text-purple-900"> Articole postate de utilizator </h2>
            <div role="articles-list" class="p-2">
                @foreach ($articles as $article)
                    @include('components.article-sample', ['article' => $article])
                    <hr class="my-4">
                @endforeach
            </div>
        </section>
    </section>
    @endif

    @if (isset($unpublished) && count($unpublished) && auth()->user() && (auth()->user()->can('publish articles') || auth()->user()->id === $user->id))
    <section class="px-2">
        <section role="articles-samples-list" class="bg-gray-100">
            <h2 class="inline text-xl font-serif font-semibold text-purple-900"> Articole nepublicate </h2>
            <div role="articles-list" class="p-2">
                @foreach ($unpublished as $article)
                    <article class="">
                        <header>
                            <h2 class="font-semibold text-lg hover:underline inline text-blue-900 mb-2">
                                <a href="{{ route('articles.show', [$article->slug]) }}">{{ $article->title }}</a>
                            </h2>
                        </header>
                        <footer class="flex justify-between">
                            <div class="hover:underline">
                                <a href="">
                                    {{ $article->book->name.($article->chapter_index ? ", $article->chapter_index" : '') }} ({{ $article->bible->name }})
                                </a>
                            </div>
                            <div>{{ $article->created_at }}</div>
                        </footer>
                    </article>
                    <hr class="my-4">
                @endforeach
            </div>
        </section>
    </section>
    @endif
@endsection