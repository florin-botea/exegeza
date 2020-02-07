@foreach ($articles as $article)
    <article>
        <header class="d-flex flex-wrap justify-content-between">
            <a class="h2 w-100 text-dark" href="{{ $article_url ?? '' }}">{{ $article->title }}</a>
            @if ($article->relationLoaded('bible'))
            <aside class="">{{ $article->bible->alias }} / {{$article->bible->book->name}}{{$article->chapter_index ? ', '.$article->chapter_index : ''}}</aside>
            @endif
            <span role="float-right" style="visibility:hidden">p</span>
            <a class="">{{ $article->author->name }}</a>
            {{-- if translation of, include here --}}
        </header>
        <div class="">
            {!! $article->sample ?? substr($article->content, 0, 500) !!}
            <a href="{{ $article_url ?? '' }}"> ...read more</a>
        </div>
    </article>
@endforeach